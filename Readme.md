# Doctor Service

#### Data

now the doctor service generate only a dummy data

![Dummy Data](./demo-data.json)


```
{
    "Users": [
	    {
	        "userId": 1,
	        "email": "test1@doctor.com",
	        "role": "doctor",
	        "stateIso": "NW"
	    },
	    {
	        "userId": 2,
	        "email": "test2@doctor.com",
	        "role": "doctor",
	        "stateIso": "BY"
	    },
	    {
	        "userId": 3,
	        "email": "test1@testcenter.com",
	        "role": "testCenter",
	        "stateIso": "NW"
	    },
	    {
	        "userId": 4,
	        "role": "testCenter",
	        "stateIso": "BY"
	    },
	    {
	        "userId": 5,
	        "email": "test1@labor.com",
	        "role": "labor",
	        "stateIso": "NW"
	    },
	    {
	        "userId": 6,
	        "email": "test2@labor.com",
	        "role": "labor",
	        "stateIso": "BY"
	    }
	]
}
```



### init

###### Technical Requirements

* Install PHP 7.4 or higher and these PHP extensions (which are installed and enabled by default in most PHP 7 installations): Ctype, iconv, JSON, PCRE, Session, SimpleXML, and Tokenizer;
* Install Composer, which is used to install PHP packages;


##### RabbitMQ

Login: admin  
Pass: admin

###### Setup
```
docker-compose pull
docker-compose up -d
composer install
```


##### PHP-Setup
```
sudo apt-get -y install gcc make autoconf libc-dev pkg-config
sudo apt-get -y install libssl-dev
sudo apt-get -y install librabbitmq-dev
sudo apt-get -y install php-pear php-dev
sudo apt-get -y install php-redis php-igbinary

sudo pecl install amqp [autodetect]

sudo touch /etc/php/7.4/cli/conf.d/20-amqp.ini
sudo echo "extension=amqp.so" >> /etc/php/7.4/cli/conf.d/20-amqp.ini
```
