
#include <LCD_I2C.h>
#include "EmonLib.h"             // Include Emon Library

LCD_I2C lcd(0x27, 20, 4);  // Default address of most PCF8574 modules, change according


EnergyMonitor emon1;             // Create an instance
EnergyMonitor emon3;            // Create an instance

int Power;
int Tarrif;
int Bill;

float powerFActor2;

#include <ESPAsyncWebServer.h>
#include <WiFi.h> 
#include <HTTPClient.h> 
String URL = "http://192.168.137.1/esp_mysql/test1.php";
const char* ssid = "Esp32"; 
const char* password = "123456789"; 

const int relayPin1 = 25;  // GPIO pin connected to the relay module
const int relayPin2 = 32; 

float V1;
float Energy;

const int trigPin = 12;
const int echoPin = 14;


String Status;

AsyncWebServer server(80);
void setup() {

  Serial.begin(115200);
  lcd.begin();
  lcd.backlight();

  
  analogReadResolution(12);
  connectWiFi();

pinMode(trigPin, OUTPUT);
pinMode(echoPin, INPUT);


  emon1.voltage(35, 118, -3.2);  // Voltage: input pin, calibration, phase_shift
  emon1.current(34, 3.8);        // Current: input pin, calibration.
 
  emon3.voltage(36, 126, -3.5);  // Voltage: input pin, calibration, phase_shift
  emon3.current(39, 3.9);  // Current: input pin, calibration.


    // Connect to Wi-Fi
    WiFi.begin(ssid, password);
    while (WiFi.status() != WL_CONNECTED) {

        Serial.println("Connecting to WiFi...");
    }
    Serial.println("Connected to WiFi");

    // Set relay pin as an OUTPUT
    pinMode(relayPin1, OUTPUT);
    pinMode(relayPin2, OUTPUT);

    // Define routes for controlling the relay
    server.on("/Relay1turnOn", HTTP_GET, [](AsyncWebServerRequest *request){
        digitalWrite(relayPin1, HIGH);
        request->send(200, "text/plain", "Relay1 turned ON");
    });

    server.on("/Relay1turnOff", HTTP_GET, [](AsyncWebServerRequest *request){
        digitalWrite(relayPin1, LOW);
        request->send(200, "text/plain", "Relay1 turned OFF");
    });

    server.on("/Relay2turnOn", HTTP_GET, [](AsyncWebServerRequest *request){
        digitalWrite(relayPin2, HIGH);
        request->send(200, "text/plain", "Relay2 turned ON");
    });

    server.on("/Relay2turnOff", HTTP_GET, [](AsyncWebServerRequest *request){
        digitalWrite(relayPin2, LOW);
        request->send(200, "text/plain", "Relay2 turned OFF");
    });

    // Start server
    server.begin();

}

void loop() {

  emon1.calcVI(100,1000);         // Calculate all. No.of half wavelengths (crossings), time-out
  emon3.calcVI(100,1000); 

  float V1 = emon1.Vrms;  //extract Vrms into Variable
  float V3 = emon3.Vrms;  //extract Vrms into Variable

  float C1 = emon1.Irms;
  float C3 = emon3.Irms;
  
  float powerFActor1 = emon1.powerFactor;  //extract Power Factor into Variable
  float powerFActor3 = emon3.powerFactor;  //extract Power Factor into Variable

  float realPower1 = emon1.realPower;
  float realPower3 = emon3.realPower;
 

  long duration, distance;
     // Clear the trigPin by setting it LOW for 2 microseconds
  digitalWrite(trigPin, LOW);
  delayMicroseconds(2);

  // Set the trigPin HIGH for 10 microseconds
  digitalWrite(trigPin, HIGH);
  delayMicroseconds(10);
  digitalWrite(trigPin, LOW);

  // Read the echoPin, and calculate the duration in microseconds
  duration = pulseIn(echoPin, HIGH);

  // Calculate the distance in centimeters
  distance = (duration * 0.0343) / 2;


if(Serial.available()>0){
 
  String data = Serial.readStringUntil('\n');

// Ensure the received data is not empty
  if (data.length() > 0) {
    // Parse the data using a delimiter (assuming commas here)
    int comma1 = data.indexOf(',');
    int comma2 = data.indexOf(',', comma1 + 1);
    int comma3 = data.indexOf(',', comma2 + 1);


    if (comma1 != -1 && comma2 != -1 && comma3 != -1) {
      // Extract values
      float Voltage2 = data.substring(0, comma1).toFloat();
      float Current2 = data.substring(comma1 + 1, comma2).toFloat();
      float PowerFActor2 = data.substring(comma2 + 1, comma3).toFloat();
      float realPower2 = data.substring(comma3 + 1).toFloat();


  long milisec = millis();     // calculate time in milliseconds
  long time = milisec / 1000;  // convert milliseconds to seconds
  Power = realPower1 + realPower2 + realPower3;
  float Energy = (Power * time) / 3600;  //Watt-sec is again convert to Watt-Hr by dividing 1hr(3600sec)
  
    
      // Print the parsed values
      Serial.print("V2=");
      Serial.println(Voltage2);
      Serial.print("C2=");
      Serial.println(Current2);
      Serial.print("PF=");
      Serial.println(PowerFActor2);

      Serial.print("Power=");
      Serial.println(realPower2);

      Serial.print("Distance=");
      Serial.println(distance);
    
     Serial.println("..................................");


  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("      R-Phase");
   lcd.setCursor(0, 1);
   lcd.print("Vrms=");
    lcd.setCursor(6, 1);
   lcd.print(V1);


     lcd.setCursor(13, 1);
   lcd.print("pf=");
     lcd.setCursor(16, 1);
     lcd.print(powerFActor1);


    lcd.setCursor(0, 2);
   lcd.print("Irms=");
       lcd.setCursor(5, 2);
       lcd.print(C1);
      lcd.setCursor(9, 2);
       lcd.print("A");

    lcd.setCursor(0, 3);
   lcd.print("Power=");
    lcd.setCursor(6, 3);
     lcd.print(realPower1);
 delay(700);
  

  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("      Y-Phase");
   lcd.setCursor(0, 1);
   lcd.print("Vrms=");
    lcd.setCursor(6, 1);
   lcd.print(Voltage2);

powerFActor2=1;
     lcd.setCursor(13, 1);
   lcd.print("pf=");
     lcd.setCursor(16, 1);
     lcd.print(powerFActor2);


    lcd.setCursor(0, 2);
   lcd.print("Irms=");
       lcd.setCursor(5, 2);
       lcd.print(Current2);
         lcd.setCursor(9, 2);
       lcd.print("A");

    lcd.setCursor(0, 3);
   lcd.print("Power=");
    lcd.setCursor(6, 3);
     lcd.print(realPower2);
   
  delay(700);

  
   
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("      B-Phase");
   lcd.setCursor(0, 1);
   lcd.print("Vrms=");
    lcd.setCursor(6, 1);
   lcd.print(V3);


     lcd.setCursor(13, 1);
   lcd.print("pf=");
     lcd.setCursor(16, 1);
     lcd.print(powerFActor3);


    lcd.setCursor(0, 2);
   lcd.print("Irms=");
       lcd.setCursor(5, 2);
       lcd.print(C3);
         lcd.setCursor(9, 2);
       lcd.print("A");

    lcd.setCursor(0, 3);
   lcd.print("Power=");
    lcd.setCursor(9, 3);
     lcd.print(realPower3);

  delay(700);



  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Total Power=");
  lcd.setCursor(12, 0);
  lcd.print(Power);

   lcd.setCursor(0, 1);
   lcd.print("Total KWhr=");
   lcd.setCursor(11, 1);
   lcd.print(Energy);


    lcd.setCursor(0, 2);
   lcd.print("Tarrif=Rs10/UNIT");

   Tarrif=10;
   Bill=Tarrif*Energy;

   lcd.setCursor(0, 3);
   lcd.print("Bill=Rs");
   lcd.setCursor(7, 3);
   lcd.print(Bill);

   
 
 
  if(WiFi.status() != WL_CONNECTED) { 
    connectWiFi();
  }
  
if (distance>20){

Status = "Cover Open";
digitalWrite(relayPin1, HIGH);
digitalWrite(relayPin2, HIGH);


 String postData = "Voltage1=" + String(V1) + " &Current1=" + String(C1) + " &Voltage2=" + String(Voltage2) + "&Current2=" + String(Current2) +  "&Voltage3=" + String(V3) + " &Current3=" + String(C3) + " &PF1=" + String(powerFActor1)+ " &PF2=" + String(powerFActor2)+ " &PF3=" + String(powerFActor3)+ " &Energy=" + String(Energy)+ " &Distance=" + String(Status);

  HTTPClient http;   
  http.begin(URL);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  int httpCode = http.POST(postData); 
  String payload = http.getString(); 
  Serial.print("URL : "); Serial.println(URL); 
  Serial.print("Data: "); Serial.println(postData); 
  Serial.print("httpCode: "); Serial.println(httpCode); 
  Serial.print("payload : "); Serial.println(payload); 
  Serial.println("--------------------------------------------------");
 
 
}
else {
  Status = "0";
  String postData = "Voltage1=" + String(V1) + " &Current1=" + String(C1) + " &Voltage2=" + String(Voltage2) + "&Current2=" + String(Current2) +  "&Voltage3=" + String(V3) + " &Current3=" + String(C3) + " &PF1=" + String(powerFActor1)+ " &PF2=" + String(PowerFActor2)+ " &PF3=" + String(powerFActor3)+ " &Energy=" + String(Energy)+ " &Distance=" + String(Status);

  HTTPClient http; 
  
http.begin(URL);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  int httpCode = http.POST(postData); 
  String payload = http.getString(); 
  Serial.print("URL : "); Serial.println(URL); 
  Serial.print("Data: "); Serial.println(postData); 
  Serial.print("httpCode: "); Serial.println(httpCode); 
  Serial.print("payload : "); Serial.println(payload); 
  Serial.println("--------------------------------------------------");
 
}}
  }
}
}

void connectWiFi() {
  WiFi.mode(WIFI_OFF);
  delay(0);
  //This line hides the viewing of ESP as wifi hotspot
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  Serial.println("Connecting to WiFi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(0);
    Serial.print(".");
  }
  Serial.print("connected to : "); Serial.println(ssid);
  Serial.print("IP address: "); Serial.println(WiFi.localIP());
}
