using System.ComponentModel.DataAnnotations;
namespace ShippingMark.Models
{
    public enum TypeNum
    {
        [Display(Name = "ROLL NO.")]
        [PrintText("ROLL NO.")] // <-- Thêm dòng này
        ROLLNO,

        [Display(Name = "PACKAGE NO.")]
        [PrintText("PACKAGE NO.")] // <-- Thêm dòng này
        PACKAGENO,

        [Display(Name = "BUNDLE NO.")]
        [PrintText("BUNDLE NO.")] // <-- Thêm dòng này
        BUNDLENO,
    }
   
}