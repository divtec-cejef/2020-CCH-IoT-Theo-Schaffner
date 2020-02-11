#include <SigFox.h>

// démarrage du programme
void setup() {
  Serial.begin(9600);
  SigFox.begin();
}

// boucle principal du programme
void loop()
{
  // temps qu'aucune console n'est ouverte ne fait rien
  while (!Serial) {};

  // affichage de la temperature
  Serial.print("Température de la carte : ");
  Serial.println(SigFox.internalTemperature());

  // attente de 5 secondes
  delay(1000*5);
}
