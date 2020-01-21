// Example testing sketch for various DHT humidity/temperature sensors
// Written by ladyada, public domain

#include "DHT.h"

#define DHTPIN 2        // Pin conncté au capteur
#define DHTTYPE DHT11   // DHT 11

DHT dht(DHTPIN, DHTTYPE); // Initialisation du capteur DHT

void setup() {
  Serial.begin(9600);
  dht.begin();
}

void loop() {
  // Attend avant la recherche des informations.
  delay(5000);

  float h = dht.readHumidity();
  float t = dht.readTemperature();

  // vérifie que la récupération des infos ait marché.
  if (isnan(h) || isnan(t)) {
    Serial.println(F("Failed to read from DHT sensor!"));
    return;
  }

  // Affichage des informations
  Serial.print("Humidity: ");
  Serial.print(h);
  Serial.print("%  Temperature: ");
  Serial.print(t);
  Serial.println("°C ");
}
