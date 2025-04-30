<?php
namespace App\Mail;

use App\Models\ChungTu;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;


class GuiChungTuMail extends Mailable
{
    use Queueable, SerializesModels;

    public $chungTu;
    public $laDoiTac;
    public $ghiChuGui;
    
    public function __construct(ChungTu $chungTu, $laDoiTac = false, $ghiChuGui = null)
    {
        $this->chungTu = $chungTu;
        $this->laDoiTac = $laDoiTac;
        $this->ghiChuGui = $ghiChuGui;
    }
    public function build()
    {
        $signedUrl = URL::signedRoute('chungtu.download.signed', [
            'chungTu' => $this->chungTu->id
        ]);

        return $this->subject('📄 NAVICO - Chứng từ: ' . $this->chungTu->tieu_de)
            ->view('emails.gui_chung_tu')
            ->with([
                'chungTu' => $this->chungTu,
                'laDoiTac' => $this->laDoiTac,
                'ghiChuGui' => $this->ghiChuGui,
                'signedUrl' => $signedUrl
            ]);
    }

}
