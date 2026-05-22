using System;
using System.Linq;
using System.Reflection;
using ShippingMark.Models; // Thay bằng namespace của bạn nếu khác

public static class EnumExtensions
{
    public static string GetPrintText(this TypeNum enumValue)
    {
        // Lấy thông tin của thành viên enum
        FieldInfo fieldInfo = enumValue.GetType().GetField(enumValue.ToString());

        // Lấy attribute PrintTextAttribute từ thành viên đó
        var attribute = (PrintTextAttribute)fieldInfo.GetCustomAttribute(typeof(PrintTextAttribute));

        // Trả về giá trị Text của attribute, nếu không có thì trả về tên của enum
        return attribute?.Text ?? enumValue.ToString();
    }
}
//< td > @ift.SelectedTypeNum.GetPrintText() </ td >