<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KySoController extends Controller
{
    public function kiemTraVanBan(Request $request)
    {
        $file = $request->file('file');
        if (!$file) return response()->json(['success' => false, 'msg' => 'Không có tệp']);

        $ext = strtolower($file->getClientOriginalExtension());
        $path = $file->store('tam');
        $absPath = storage_path("app/{$path}");

        $result = match ($ext) {
            'xml' => $this->kiemTraXML($absPath),
            'pdf' => $this->kiemTraPDF($absPath),
            'docx' => $this->kiemTraDOCX($absPath),
            default => ['success' => false, 'msg' => 'Định dạng không hỗ trợ']
        };

        Storage::delete($path);
        return response()->json($result);
    }

    private function kiemTraXML($path)
    {
        $xml = simplexml_load_file($path);
        if (!$xml) return ['success' => false, 'msg' => 'Không đọc được XML'];

        $xml->registerXPathNamespace('ds', 'http://www.w3.org/2000/09/xmldsig#');
        $sig = $xml->xpath('//ds:Signature');
        if (!$sig) return ['success' => false, 'msg' => 'Không có chữ ký số'];

        $subject = (string)($xml->xpath('//ds:X509SubjectName')[0] ?? '');
        preg_match('/CN=([^,]+)/u', $subject, $matches);
        return [
            'success' => true,
            'msg' => 'XML đã ký số',
            'data' => [
                'don_vi_ky' => $matches[1] ?? 'Không rõ',
                'subject' => $subject,
                'signing_time' => (string)($xml->xpath('//ds:SigningTime')[0] ?? '')
            ]
        ];
    }

    private function kiemTraPDF($path)
    {
        $output = shell_exec("pdfsig \"$path\" 2>&1");
        if (str_contains($output, 'Signature is VALID')) {
            preg_match('/Common Name: (.+)/', $output, $cn);
            preg_match('/Signing time: (.+)/', $output, $time);
            return [
                'success' => true,
                'msg' => 'PDF đã ký số hợp lệ',
                'data' => [
                    'don_vi_ky' => $cn[1] ?? 'Không rõ',
                    'signing_time' => $time[1] ?? '',
                    'subject' => ''
                ]
            ];
        }
        return ['success' => false, 'msg' => 'PDF chưa ký số hoặc không hợp lệ'];
    }

    private function kiemTraDOCX($path)
    {
        $zip = new \ZipArchive;
        if ($zip->open($path) === true) {
            $hasSig = $zip->locateName('word/signatures.xml') !== false;
            $zip->close();
            return $hasSig
                ? ['success' => true, 'msg' => 'DOCX đã được ký số', 'data' => []]
                : ['success' => false, 'msg' => 'DOCX chưa được ký số'];
        }
        return ['success' => false, 'msg' => 'Không mở được DOCX'];
    }
}
