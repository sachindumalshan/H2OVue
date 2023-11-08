#include <WiFi.h>
#include <HTTPClient.h>

#define WaterFlowSensor 27

String URL = "http://OP_ADDRESS/wbms/connect.php?";

const char* ssid = "YOUR_WIFI_SSID"; 
const char* password = "YOUR_WIFI_PASSWORD"; 

int flowread = 0;

// Water Flow Sensor Timing Variables
long water_currentMillis = 0;
long water_previousMillis = 0;
int water_interval = 1000;
float water_calibrationFactor = 4.5;
volatile byte water_pulseCount;
byte water_pulse1Sec = 0;
float water_flowRate;
unsigned int water_flowMilliLitres;
unsigned long water_totalMilliLitres;

//Databse Timing Variable
long database_currentMillis = 0;
long database_previousMillis = 0;
unsigned long database_resetInterval = 2 * 60 * 1000; // 5 minutes in milliseconds 
unsigned long database_lastResetMillis = 0;
unsigned long database_lastSendMillis = 0;
boolean database_sendData = false;

void IRAM_ATTR water_pulseCounter()
{
  water_pulseCount++;
}

void setup() {
  Serial.begin(115200);
  pinMode(WaterFlowSensor, INPUT_PULLUP);

  //water
  water_pulseCount = 0;
  water_flowRate = 0.0;
  water_flowMilliLitres = 0;
  water_totalMilliLitres = 0;
  water_previousMillis = 0;

  //database
  database_previousMillis = 0;
  database_lastResetMillis = millis();
  database_lastSendMillis = 0;

  attachInterrupt(digitalPinToInterrupt(WaterFlowSensor), water_pulseCounter, FALLING);
  
  connectWiFi();
}

void loop() {
  if(WiFi.status() != WL_CONNECTED) {
    connectWiFi();
  }

  Water_Flow_Read();
  database_currentMillis = millis();

  if (database_currentMillis - database_lastSendMillis >= database_resetInterval)
  {
    database_sendData = true;
    database_lastSendMillis = database_currentMillis;
  }

  if (database_sendData)
  {
    String postData = "flowread=" + String(flowread);
    water_totalMilliLitres=0;
    HTTPClient http;
    http.begin(URL);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    int httpCode = http.POST(postData);
    String payload = "";

    if (httpCode > 0)
    {
      // file found at server
      if (httpCode == HTTP_CODE_OK)
      {
        String payload = http.getString();
        Serial.println(payload);
      }
      else
      {
        // HTTP header has been sent and Server response header has been handled
        Serial.printf("[HTTP] GET... code: %d\n", httpCode);
      }
    }
    else
    {
      Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
    }

    http.end(); // Close connection

    Serial.print("URL : ");
    Serial.println(URL);
    Serial.print("Data: ");
    Serial.println(postData);
    Serial.print("httpCode: ");
    Serial.println(httpCode);
    Serial.print("payload : ");
    Serial.println(payload);
    Serial.println("--------------------------------------------------");

    database_sendData = false;
  }  
  delay(1000);
}


void Water_Flow_Read() {
    water_currentMillis = millis();
    if (water_currentMillis - water_previousMillis > water_interval) {
      
      water_pulse1Sec = water_pulseCount;
      water_pulseCount = 0;
  
      water_flowRate = ((1000.0 / (millis() - water_previousMillis)) * water_pulse1Sec) / water_calibrationFactor;
      water_previousMillis = millis();
  
      water_flowMilliLitres = (water_flowRate / 60) * 1000;
  
      // Add the millilitres passed in this second to the cumulative total
      water_totalMilliLitres += water_flowMilliLitres;
      
      // Print the flow rate for this second in litres / minute
      Serial.print("Flow rate: ");
      Serial.print(int(water_flowRate));
      Serial.print("L/min");
      Serial.print("\t");
  
      // Print the cumulative total of litres flowed since starting
      Serial.print("Output Liquid Quantity: ");
      Serial.print(water_totalMilliLitres);
      Serial.print("mL / ");
      Serial.print(water_totalMilliLitres / 1000);
      Serial.println("L");

      flowread = water_totalMilliLitres;
    }
}

void connectWiFi() {
  WiFi.mode(WIFI_OFF);
  delay(1000);
  
  //This line hides the viewing of ESP as wifi hotspot
  WiFi.mode(WIFI_STA);
  
  WiFi.begin(ssid, password);
  Serial.println("Connecting to WiFi");
  
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
    
  Serial.print("connected to : "); Serial.println(ssid);
  Serial.print("IP address: "); Serial.println(WiFi.localIP());
}
