#include "DHT.h"
#include <ArduinoLowPower.h>
#include <SigFox.h>

#define DHTPIN 2        // Pin conncté au capteur
#define DHTTYPE DHT11   // DHT 11

DHT dht(DHTPIN, DHTTYPE); // Initialisation du capteur DHT

void setup() 
{  
    dht.begin();
    SigFox.begin();
    SigFox.end();
}

// ajout d'une structure pour simplifier le tout
typedef struct __attribute__ ((packed)) sigfox_message {
    int8_t temp;
    int8_t hum;
} SigfoxMessage;

void loop()
{
  SigfoxMessage msg;
  msg.temp = static_cast<int>(dht.readTemperature());
  msg.hum = static_cast<int>(dht.readHumidity());

  SigFox.begin();
  SigFox.beginPacket();
  SigFox.write((uint8_t*)&msg,sizeof(msg));
  SigFox.endPacket();
  SigFox.end();

  delay(1000*60*15);
}
