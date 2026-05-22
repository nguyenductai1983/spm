using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace ShippingMark.Models
{
    public class Container
    {
        [Key]
        public int ID { get; set; }

        // --- Liên kết đến ThongBaoXuatHang (Phiếu cha) ---
        [ForeignKey("ThongBaoXuatHang")]
        public int ThongBaoXuatHang_ID { get; set; }
        public virtual ThongBaoXuatHang ThongBaoXuatHang { get; set; }

        // --- SỬA LỖI: Cho phép khóa ngoại có thể null ---
        [Display(Name = "Model")]
        [ForeignKey("ChiTietHangHoa")]
        public int? ChiTietHangHoa_ID { get; set; } // Thêm dấu ? để cho phép NULL
        public virtual ChiTietHangHoa ChiTietHangHoa { get; set; }       
        [Display(Name = "Container số")]
        public string ContainerSo { get; set; }

        [Display(Name = "Kích cỡ container")]
        public string KichCo { get; set; }

        [Display(Name = "Số lượng")]
        public string SoLuong { get; set; }

        [Display(Name = "Từ")]
        public string Tu { get; set; }

        [Display(Name = "Đến")]
        public string Den { get; set; }

        [Display(Name = "Ghi chú")]
        public string GhiChu { get; set; }
    }
}