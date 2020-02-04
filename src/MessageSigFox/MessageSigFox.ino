#include "DHT.h"
#include <RTCZero.h>
#include <ArduinoLowPower.h>
#include <SigFox.h>

#define DHTPIN 2 // pin connecté
#define DHTTYPE DHT11   // DHT 11 

DHT dht(DHTPIN, DHTTYPE);

void setup() 
{    
    dht.begin();
    SigFox.begin();
    SigFox.end();
}

typedef struct __attribute__ ((packed)) sigfox_message {
    int8_t temp;
    int8_t hum;
} SigfoxMessage;

void loop() 
{
    float temp_hum_val[2] = {0};   
    int temp = 0;
    int hum = 0;

    //get the data
    if (!dht.readTempAndHumidity(temp_hum_val)) {
        SigfoxMessage msg;
        
        temp = static_cast<int>(temp_hum_val[1]);
        hum = static_cast<int>(temp_hum_val[0]);

        msg.temp = temp;
        msg.hum = hum;
        SigFox.begin();
        SigFox.beginPacket();
        SigFox.write((uint8_t*)&msg,sizeof(msg));
        SigFox.endPacket();
        SigFox.end();
    }
   delay(1000*60*15);
}
