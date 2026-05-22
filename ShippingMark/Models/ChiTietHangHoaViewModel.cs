using System.ComponentModel.DataAnnotations;
using ShippingMark.Models; // Namespace chứa enum TypeNum

namespace ShippingMark.Models
{
    public class ChiTietHangHoaViewModel
    {
        public int ID { get; set; }
        [Display(Name = "MODEL")]
        public string MODEL { get; set; }

        [Display(Name = "SIZE Kích thước")]
        public string SIZE { get; set; }
        [Display(Name = "Số lượng")]
        public string SoLuong { get; set; }
        [Display(Name = "Net weight")]
        public string NW { get; set; }

        [Display(Name = "Gross weight")]
        public string GW { get; set; }

        [Display(Name = "Dài (m)")]
        public decimal? Dai { get; set; }

        [Display(Name = "Rộng (m)")]
        public decimal? Rong { get; set; }

        [Display(Name = "Cao (m)")]
        public decimal? Cao { get; set; }

        [Display(Name = "Màu (Color)")]
        public string COLOR { get; set; }

        [Display(Name = "Lô")]
        public string LotNo { get; set; }

        [Display(Name = "Loại đóng gói")]
        public TypeNum SelectedTypeNum { get; set; }

        [Display(Name = "Nội dung mở rộng")]
        public string ExtendedContent { get; set; }
        [Display(Name = "QUANTITY")]
        public string QUANTITY { get; set; }
        // === THÊM THUỘC TÍNH MỚI ===
        [Display(Name = "Số lượng tham khảo")]
        public int SoLuongThamKhao { get; set; }
        [Display(Name = "Thông báo xuất hàng")]
        public int ThongBaoXuatHang_ID { get; set; }
        [Display(Name = "Tổng số lượng (từ Containers)")]
        public long TongSoLuongTrongContainer { get; set; }
    }
}
