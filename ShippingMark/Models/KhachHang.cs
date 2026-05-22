using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Collections.Generic;
namespace ShippingMark.Models
{
    public class KhachHang
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public int ID { get; set; }
        [Display(Name = "Mã dùng để tham chiếu đến mẫu in")]
        public string Code { get; set; }
        [Display(Name = "Tên")]
        public string Name { get; set; }
        public virtual ICollection<ThongBaoXuatHang> ThongBaoXuatHangs { get; set; }
    }

}