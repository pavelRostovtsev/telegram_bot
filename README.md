пример того как установить сертификат:
curl -F "url=https://ваш айпи или доменное имя:порт/" -F "certificate=@путь к сертификату(ну или перейдите в папку где он лежит и можно просто указать имя)" "https://api.telegram.org/botТОКЕНБОТА/setwebhook"

если бот шлет нахуй, обычно помогает
POST tg.api/bottoken/setWebhook to emtpy "url"
POST tg.api/bottoken/getUpdates
POST tg.api/bottoken/getUpdates with "offset" last update_id appeared before