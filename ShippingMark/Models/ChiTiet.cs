using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
namespace ShippingMark.Models
{    
    public class ChiTiet
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public int ID { get; set; }
        [Display(Name = "REFNO Đơn hàng")]
        public string REFNO { get; set; }
        [Display(Name = "PoNo Số PO")]
        public string PoNo { get; set; }
        [Display(Name = "MODEL")]
        public string MODEL { get; set; }
        [Display(Name = "SIZE Kích thước")]
        public string SIZE { get; set; }
        // Thêm các trường còn lại theo cấu trúc bảng
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

        public string Type { get; set; }
        [Display(Name = "Loại đóng gói")]
        public TypeNum SelectedTypeNum { get; set; }

        [Display(Name = "Nội dung mở rộng")]
        public string TypeSuffix { get; set; }
        [Display(Name = "In")]
        public bool? usingPrint { get; set; }
        [Display(Name = "Bắt đầu")]
        public string StartSerial { get; set; }
        [Display(Name = "Số lượng")]
     
        public string NumSerial { get; set; }
        [Display(Name = "Lô")]
        public string LotNo { get; set; }
        [Display(Name = "Khách hàng")]
        public string Customer { get; set; }
        public string QUANTITY { get; set; }
        public string COMMODITY { get; set; }
        public string CustomerCode { get; set; }

        // Ghi nhận thông tin user
        public string CreatedBy { get; set; }
        [Column(TypeName = "datetime2")]
        public DateTime CreatedDate { get; set; }
        public string LastModifiedBy { get; set; }
        [Column(TypeName = "datetime2")]
        public DateTime? LastModifiedDate { get; set; }
    }
}