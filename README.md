# Quick Start Guide
A Library to store bookmarks for comics, webnovels and animes.
You can access the demo or use it permanently [here](https://public.tellarin.dev).
The Docker version is available [here](https://github.com/xTellarin/alexandria-docker).

![PHP requirements badge](https://img.shields.io/badge/php-7%20%7C%208%20%7C%208.1-purple)
![Hosting Badge](https://img.shields.io/badge/Hosting-Public%20%7C%20Self%20Hosted%20%7C%20Docker-blue)
![Development Status Badge](https://img.shields.io/badge/Development%20Status-Active-green)

Welcome to Alexandria. 
The Library has been developed first and foremost for Linux systems, on a remote (VPS) or local (NAS with VM) server. While you *can* use it directly on your machine, keep in mind you'll have to start the apache web server every time you want to access the Library. If you don't have access to a server (VPS or NAS VM), I'm maintaining [a Docker version](https://github.com/xTellarin/alexandria-docker) for use on your computer (or a NAS). 

The Library is designed to be self-hosted, preferably on a subdomain (especially if you don't want to modify the code at all). You can of course change the location to wherever you want, but you will need to adjust the path to your `secure` directory accordingly. If you want to see what it looks like in action, you can access the demo at the link above.

# Installation

I am assuming that you already have the LAMP stack installed and a web server up and running. If you don't, you should start with that first. 

The requirements for Alexandria are very basic: a functioning apache server, php>7 (with the mysql plugin) and MySQL>8.0 (or MariaDB).
On Ubuntu and Debian derivatives, make sure you have everything by running: 
```bash
sudo apt install apache2 php8.1 php-mysql mysql-server
```
> NOTE:
> I am installing php 8.1 here. If you need a different version of php elsewhere, leave that out but make sure you still have php>7.

The basic installation process is as follows: 
- Create your `secure` directory
- Clone Alexandria
- \[Optional]  Adjust the paths to your `secure` directory
- Create your databases

## Creating the `secure` folder

In your web root directory (usually `/var/www/html`), start by creating a folder named `secure` (`mkdir secure`). Again, that folder is **outside** of your domain directory so that it cannot be accessed on the web.
Create a new file called `config.php` using the text editor of your choice (I recommend nano or vim, there's not much to write) and paste / write the following content:

```php
<?php
	$host = "localhost";
	$dbuser = "[your_DB_username]";
	$dbpassword = "[your_DB_password]";
	$database = "alexandria";
?>
```

Change the \[username] and \[password] to whatever you want. Make sure not to use `root` for security reasons.
Save your file and exit, you're done here. 

\[Optional] You might want to assign the correct file permissions for security too: `sudo chmod 644 config.php` 

## Clone Alexandria

At the root of your web directory, clone the GitHub repository. 
``` bash
sudo git clone https://github.com/xTellarin/alexandria.git
```

Again, you can put Alexandria wherever you want, but be sure to change the location of the `secure` directory in the php files if you install it somewhere else. 
If you do install it as a subdomain, remember to go to your domain provider and create a new CNAME record pointing to your domain name. You'll also need to add a new host file and, optionally, a new SSL certificate (with certbot). 

## Create the database
If that's your first time using MySQL, follow a tutorial to properly set up your installation. 
Once you're done, come back here to create the backend to store your bookmarks. 

Let's start with the database itself. Run 
```sql 
CREATE DATABASE alexandria;
``` 
You can name it something else, but remember to adjust your `config.php` file. 

Next, let's create the two tables: one for storing user information (yours, possibly family, friends and strangers too) and the other for the bookmarks themselves.

```sql
CREATE TABLE alexandria.users(  
    id INT AUTO_INCREMENT PRIMARY KEY,  
    username VARCHAR(50),  
    password VARCHAR(255)
);
```

```sql
CREATE TABLE alexandria.records(  
    id INT AUTO_INCREMENT PRIMARY KEY,  
    title VARCHAR(255),  
    rating VARCHAR(255),  
    tags VARCHAR(255),  
    chapters VARCHAR(255),  
    link VARCHAR(255),  
    team VARCHAR(255),  
    lastRead DATE,  
    userID INT NOT NULL  
);
```

For security purposes, we're not using the `root` user to make calls and changes to our database as explained above. So, first let's create our user.

```sql
CREATE USER '[your_DB_username]'@'localhost' IDENTIFIED BY '[your_DB_password]';
```
Next, we'll give the correct permissions to the database user created previously.
```SQL
GRANT ALL ON alexandria.* TO '[your_DB_username]'@'localhost' WITH GRANT OPTION;
```


Congratulation, we're done with the installation !
Before we move on to using Alexandria, here's an FAQ:

### FAQ
**Q: I have an error 500 when I try to reach the login page (autoredirect)**

A: You might want to check your php logs first. On Ubuntu and Debian derivatives you can find the log file in `/var/log/apache2/error.log'` Running 
```bash
sudo tail /var/log/apache2/error.log
```
should give you a pretty good idea of what's wrong. 
Otherwise, you can try changing file and folder ownership to apache2: 
```bash
sudo chown www-data:www-data alexandria/*
sudo chmod 775 alexandria/*
```
Note that `www-data` is the group to which apache2 belongs on Ubuntu and Debian-derivative distros. You will probably need to change that on other flavors. 

# Usage
When you head to Alexandria on your browser, you'll be greeted with the login page. I make use of the php sessions to check whether a user is identified or not. 
So, go ahead and click *Create account*. Choose a username and password. The case (capital letters) doesn't matter for the username, so *Tellarin* and *tellarin* are the same. I prefer using a capital letter when I log in, but that's entirely up to you.
Once you've logged in, you'll see the splash / landing page. Not much to see here, so click the *Library button*. 

Welcome to Alexandria. The Library is quite sparse to say the least, but not for long. Let's add your first bookmark. Click *Add a new record*.
Fill in the fields with the details of the comic / novel / anime you'd like to save.  Note that 'Team' refers to the Author or the Translator. Which one you want to use is up to you. You can filter on this field too so choose wisely, and most importantly, stay consistent. You will always be able to change it later if you need. Click *Submit* when you're done.

Congratulation! Your first entry now populates your library. Notice how the 'Last Read On' field is automatically filled with today's date. It's convenient to see how much time has passed since you last read / watched your bookmark. 
In a few weeks, once you've caught up again, you'll probably want to update the chapter at which you stopped at. While you can do so by clicking the *Edit* button in the 'Edit info' column, a much quicker way to do it is by inputting the chapter number next to *Last Chapter read* at the top. Then, click *Update* on the record you'd like to update. That's it!

Finally, remember that you can also filter by tag and team using the dedicated fields at the top. As your library fills up with all sorts of bookmarks, you'll appreciate this feature. 

# Other notes / FAQ

You are now ready to use Alexandria. If you want to dive deeper on customization, I've got more (illustrated) documentation for you [on my blog](https://blog.tellarin.dev/alexandria).

**Q: I don't have access to a server, how can I use Alexandria?**

A: You can use the [demo](public.tellarin.dev) available on my website. I say demo, but you definitely can use it for as long as you'd like. Just be aware that support can be limited. 
I'm also mainting [a Docker container](https://github.com/xTellarin/alexandria-docker) so that you can host it on your machine directly. 


**Q: I've got other questions, how can I reach you?**

A: You can send me a message on Discord (Tellarin#0069) or [send me an email](mailto:hello@tellarin.dev). You can also use the Discussions tab at the top of this page. That's what it's made for :)

Feel free to submit Pull Requests if there's something you'd like to improve, an Issue if something is wrong (read the Installation paragraph thoroughly first) or create a new Discussion (at the top of this page) for other things you'd like to share. 

Thank you for using Alexandria!

\- Tellarin
