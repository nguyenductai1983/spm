using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Collections.Generic;
namespace ShippingMark.Models
{   
    public class ChiTietHangHoa
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public int ID { get; set; }       
        [Display(Name = "MODEL")]
        public string MODEL { get; set; }
        [Display(Name = "SIZE Kích thước")]
        public string SIZE { get; set; }
        [Display(Name = "Số lượng")]
        public int SoLuongThamKhao { get; set; }
        // Thêm các trường còn lại theo cấu trúc bảng IFT
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
        [Display(Name = "Loại đóng gói")]
        public TypeNum SelectedTypeNum { get; set; }

        [Display(Name = "Nội dung mở rộng")]
        public string ExtendedContent { get; set; }
        [Display(Name = "In")]
        public bool? UsingPrint { get; set; }      
        [Display(Name = "Lô")]
        public string LotNo { get; set; }
        public string QUANTITY { get; set; }
        [Display(Name = "Thông báo xuất hàng")]
        public string CreatedBy { get; set; }
        [Column(TypeName = "datetime2")]
        public DateTime CreatedDate { get; set; }
        public string LastModifiedBy { get; set; }
        [Column(TypeName = "datetime2")]
        public DateTime? LastModifiedDate { get; set; }
        [Display(Name = "Thông báo xuất hàng")]
        [ForeignKey("ThongBaoXuatHang")]
        public int ThongBaoXuatHang_ID { get; set; }
        public virtual ThongBaoXuatHang ThongBaoXuatHang { get; set; }
        // === BỔ SUNG LIÊN KẾT NGƯỢC VỀ CONTAINER (QUAN HỆ NHIỀU-NHIỀU) ===
        public virtual ICollection<Container> Containers { get; set; }
    }
}