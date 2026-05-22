using System;

// Attribute này dùng để lưu trữ văn bản sẽ được in ra
[AttributeUsage(AttributeTargets.Field)]
public class PrintTextAttribute : Attribute
{
    public string Text { get; }

    public PrintTextAttribute(string text)
    {
        this.Text = text;
    }
}