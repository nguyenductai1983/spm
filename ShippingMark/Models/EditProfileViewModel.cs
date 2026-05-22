using System.ComponentModel.DataAnnotations;

namespace ShippingMark.Models
{
    // ViewModel này chỉ dùng cho form chỉnh sửa thông tin cá nhân
    public class EditProfileViewModel
    {
        [Required(ErrorMessage = "Vui lòng nhập họ và tên.")]
        [Display(Name = "Họ và Tên")]
        [StringLength(100)]
        public string FullName { get; set; }
    }
}
