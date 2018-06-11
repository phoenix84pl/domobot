// The List on the next line is the GPIO pins that you hooked up 
var matrixPad = new MatrixKeypadMonitor(new List<int> { 16, 20, 21, 5, 6, 13, 19, 26 }); 
// Subscribe to an event that is triggered when a keypress happens 
if (matrixPad.SetupSuccessful) 
{
   matrixPad.FoundADigitEvent += FoundDigit; 
} 
else 
{
   Debug.WriteLine(matrixPad.SetupMessage); 
}
// This event gets triggered when a key is pressed
public void FoundDigit(object sender, string digit) 
{   
  // Do something here with your keypress 
  Debug.WriteLine(string.Format("{0} was pressed!", digit));   
}
