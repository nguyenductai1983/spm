using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace ShippingMark.Models
{
    public class ThongBaoXuatHang
    {
        // --- BƯỚC 1: Thêm Constructor để khởi tạo các danh sách ---
        public ThongBaoXuatHang()
        {
            this.Containers = new HashSet<Container>();
            this.ChiTietHangHoas = new HashSet<ChiTietHangHoa>();
        }

        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public int ID { get; set; }

        [Display(Name = "Loại hàng")]
        public string LoaiHang { get; set; }

        [Display(Name = "Số lượng")]
        public int SoLuong { get; set; }

        [Display(Name = "REFNO Đơn hàng")]
        public string REFNO { get; set; }

        [Display(Name = "PoNo Số PO")]
        public string PoNo { get; set; }

        [Required(ErrorMessage = "Vui lòng chọn ngày dự kiến.")]
        [DataType(DataType.Date)]
        [DisplayFormat(DataFormatString = "{0:yyyy-MM-dd}", ApplyFormatInEditMode = true)]
        [Display(Name = "Ngày dự kiến")]
        public DateTime? Ngaydukien { get; set; }

        [Required(ErrorMessage = "Vui lòng chọn ngày ETD.")]
        [DataType(DataType.Date)]
        [DisplayFormat(DataFormatString = "{0:yyyy-MM-dd}", ApplyFormatInEditMode = true)]
        [Display(Name = "Ngày ETD")]
        public DateTime? NgayETD { get; set; }

        [Display(Name = "Ghi chú")]
        public string GhiChu { get; set; }

        // --- Liên kết đến các bảng khác ---
        [ForeignKey("KhachHang")]
        public int? KhachHang_ID { get; set; }
        public virtual KhachHang KhachHang { get; set; }

        [ForeignKey("HangHoa")]
        public int? HangHoa_ID { get; set; }
        public virtual HangHoa HangHoa { get; set; }
        // === BẮT ĐẦU NÂNG CẤP ===
        // Lưu thông tin người tạo và thời gian tạo
        [ForeignKey("CreatedByUser")]
        public string CreatedById { get; set; }
        public virtual ApplicationUser CreatedByUser { get; set; }
        public DateTime CreatedDate { get; set; }

        // Lưu thông tin người sửa cuối cùng và thời gian sửa
        [ForeignKey("LastModifiedByUser")]
        public string LastModifiedById { get; set; }
        public virtual ApplicationUser LastModifiedByUser { get; set; }
        public DateTime? LastModifiedDate { get; set; }
        // === KẾT THÚC NÂNG CẤP ===

        // --- Các thuộc tính Collection ---
        public virtual ICollection<Container> Containers { get; set; }
        public virtual ICollection<ChiTietHangHoa> ChiTietHangHoas { get; set; }
    }
}
