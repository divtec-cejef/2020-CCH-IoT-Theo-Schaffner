#include <SigFox.h>

// démarrage du programme
void setup() {
  Serial.begin(9600);
  SigFox.begin();

  //affichage des informations
  while(!Serial){};
  Serial.println("ID  = " + SigFox.ID());
  Serial.println("PAC = " + SigFox.PAC());
  
  delay(1000*5);
}

void loop() {}
