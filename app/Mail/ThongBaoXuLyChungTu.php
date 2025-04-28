<?php

namespace App\Mail;

use App\Models\ChungTu;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ThongBaoXuLyChungTu extends Mailable
{
    use Queueable, SerializesModels;

    public $chungTu;
    public $nguoiNhan;
    public $loaiThongBao;
    public $tieuDeMail;
    public $moTaTrangThai;

    /**
     * Tạo mới mail thông báo xử lý chứng từ
     *
     * @param ChungTu $chungTu
     * @param User $nguoiNhan
     */
    public function __construct(ChungTu $chungTu, User $nguoiNhan)
    {
        $this->chungTu = $chungTu;
        $this->nguoiNhan = $nguoiNhan;
        $this->loaiThongBao = $this->xacDinhLoaiThongBao();
        $this->tieuDeMail = $this->buildTieuDeMail();
        $this->moTaTrangThai = $this->buildMoTaTrangThai();
    }

    /**
     * Xác định loại thông báo dựa vào trạng thái chứng từ
     */
    protected function xacDinhLoaiThongBao()
    {
        $maTrangThai = $this->chungTu->trangThai->ma_trang_thai ?? '';

        return match ($maTrangThai) {
            'TAO_MOI' => 'can_duyet_cap_phong',
            'DA_DUYET_CAP_PHONG' => 'can_duyet_lanh_dao',
            'DA_DUYET' => 'can_ky_so',
            'DA_BAN_HANH' => 'da_ky_so',
            'KY_SO' => 'da_gui',
            'DA_GUI' => 'can_luu_tru',
            'TU_CHOI' => 'bi_tu_choi',
            default => 'thong_bao',
        };
    }

    /**
     * Tạo tiêu đề email dựa theo loại thông báo
     */
    protected function buildTieuDeMail()
    {
        return match ($this->loaiThongBao) {
            'can_duyet_cap_phong' => '📋 Cần Duyệt Cấp Phòng - Chứng Từ Mới',
            'can_duyet_lanh_dao' => '📋 Cần Duyệt Lãnh Đạo - Chứng Từ',
            'can_ky_so' => '🖊️ Cần Ký Số - Chứng Từ',
            'da_ky_so' => '✅ Đã Ký Số - Chứng Từ Hoàn Tất',
            'bi_tu_choi' => '❌ Chứng Từ Bị Từ Chối',
            'da_gui' => '📤 Chứng Từ Đã Gửi',
            'can_luu_tru' => '🗂️ Cần Lưu Trữ Chứng Từ',
            default => '📢 Thông Báo Chứng Từ',
        };
    }

    /**
     * Tạo mô tả trạng thái xử lý cho email
     */
    protected function buildMoTaTrangThai()
    {
        return match ($this->loaiThongBao) {
            'can_duyet_cap_phong' => 'Chứng từ cần được Trưởng/Phó phòng duyệt cấp phòng.',
            'can_duyet_lanh_dao' => 'Chứng từ cần được Giám đốc/Phó giám đốc xét duyệt.',
            'can_ky_so' => 'Chứng từ cần được Giám đốc ký số.',
            'da_ky_so' => 'Chứng từ đã ký số thành công.',
            'bi_tu_choi' => 'Chứng từ đã bị từ chối xử lý.',
            'da_gui' => 'Chứng từ đã được gửi ra ngoài đối tác.',
            'can_luu_tru' => 'Chứng từ cần được bộ phận lưu trữ tiếp nhận.',
            default => 'Xem xét và xử lý chứng từ theo quy trình.',
        };
    }

    /**
     * Tiêu đề email
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->tieuDeMail
        );
    }

    /**
     * Nội dung mail
     */
    public function content()
    {
        return new Content(
            view: 'emails.thong_bao_xu_ly_chung_tu',
            with: [
                'chungTu' => $this->chungTu,
                'nguoiNhan' => $this->nguoiNhan,
                'loaiThongBao' => $this->loaiThongBao,
                'tieuDeMail' => $this->tieuDeMail,
                'moTaTrangThai' => $this->moTaTrangThai,
            ],
        );
    }

    /**
     * File đính kèm (không có)
     */
    public function attachments()
    {
        return [];
    }
}
