#include <WiFi.h>
//lcd를 위함
#include <Wire.h> 
#include <LiquidCrystal_I2C.h>
LiquidCrystal_I2C lcd(0x27,16,2);

const char * host = "10.150.149.52";
const int Port = 80;

const char* ssid = "bssm_free";
const char* password = "bssm_free";

WiFiClient client;
unsigned long web_t = 0;
unsigned long lcd_t = 0;

int old_state = LOW;
int falling_edge = false; //하강엣지 검출안됨,
int rising_edge = false;
unsigned long t = 0;

float led = 0;

void setup() {
  Serial.begin(115200); //시리얼 모니터 오픈
  //pinMode(15, OUTPUT); //LED
  pinMode(26, INPUT);//모션센서

  //인터넷 공유기와 접속!
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid,password);
  while(WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print("0");
  }
  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());

  //lcd
  lcd.init();
  lcd.backlight();
  lcd.setCursor(0,0);
  lcd.print("LED");
}
 
void loop() { 
  led = 0;
  if(falling_edge == true && millis() - t > 3000){ //LED 끄는 부분
    analogWrite(15, 0);
    falling_edge = false;
    led = 0;
  }

  int state = digitalRead(26); //현재 상태
  
  if(state == HIGH && old_state == LOW){
    //int cds = analogRead(36); //A1으로 들어오는 값을 cds에 저장
    //analogWrite(15,map(cds,0,4095,0,255));
    rising_edge = true;
  }
  if(rising_edge == true){ //LED 켜지는 부분!
    int cds = analogRead(36); //A1으로 들어오는 값을 cds에 저장
    led = map(cds,0,4095,0,255);
    analogWrite(15,led);
    Serial.println(led);
  }
  
  if(state == LOW && old_state == HIGH){
    t = millis();
    rising_edge = false;
    falling_edge = true;
  }
  //현재 상태를 과거 상태에 저장한다
  old_state = state;

  if(millis() - web_t > 1000){
    web_t = millis();
    if(!client.connect(host,Port)){
      Serial.println("접속 실패!");
      return;
    }
    int cds_data = analogRead(36); //조도센서
    int motion_data = digitalRead(26); //모션센서

    String url = "/Project/upload.php?led="+String(int(led/255*100))+"&light="+String(cds_data)+"&motion="+String(motion_data);
    client.print(String("GET ") + url + "HTTP/1.1\r\n"+
                  "Host: " +host+"\r\n" +
                  "Connection: close\r\n\r\n");
    // 서버가 클라이언트에게 response 전송
    unsigned long t = millis(); //생존시간
    while(1){
      if(client.available()) break;
      if(millis() - t > 10000) break;
    }
    //응답이 왔거나 시간안에 응답이 안왔다
    Serial.println("응답 도착");
    //서버가 전송한 모든 데이터를 시리얼로 출력
    while(client.available()){
      Serial.write(client.read());
    }
  }
  if(millis() - lcd_t > 1000){
    lcd_t = millis();
    lcd.setCursor(0,1);
    lcd.print(led/255*100);
    lcd.print("%");
    lcd.print("     ");
  }
  
  
  delay(10);
}
