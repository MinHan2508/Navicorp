<?php

namespace App\Mail;

use App\Models\ChungTu;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ThongBaoXuLyChungTu extends Mailable
{
    use Queueable, SerializesModels;

    public $chungTu;
    public $tieuDeMail;

    public function __construct(ChungTu $chungTu)
    {
        $this->chungTu = $chungTu;
    
        $trangThai = $chungTu->trangThai->ma_trang_thai ?? null;
        $vaiTroNguoiTao = $chungTu->nguoiTao->vaiTro->ma_vai_tro ?? null;
    
       
        if ($trangThai === 'TAO_MOI') {
            if ($vaiTroNguoiTao === 'nhanvien') {
                $this->tieuDeMail = 'Đã tạo chứng từ';
            } elseif (in_array($vaiTroNguoiTao, ['truongphong', 'pho_phong'])) {
                $this->tieuDeMail = 'Cần Trưởng Phó phòng xét duyệt';
            } else {
                $this->tieuDeMail = 'Thông báo chứng từ mới cần xem xét';
            }
        } else {
            $this->tieuDeMail = match ($trangThai) {
                'DA_DUYET_CAP_PHONG' => 'Cần duyệt',
                'DA_DUYET' => 'Cần duyệt lãnh đạo',
                'KY_SO' => 'Cần ký số',
                'DA_GUI' => 'Đã gửi chứng từ',
                default => 'Thông báo chứng từ',
            };
        }
    }
    

    public function envelope()
    {
        return new Envelope(
            subject: 'Thông báo: ' . $this->tieuDeMail
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.thong_bao_xu_ly_chung_tu',
            with: [
                'chungTu' => $this->chungTu,
                'tieuDeMail' => $this->tieuDeMail
            ],
        );
    }

    public function attachments()
    {
        return [];
    }
}

    