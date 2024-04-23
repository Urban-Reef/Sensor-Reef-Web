# Setting up dev environment
This guide explains how to set up a development environment for windows.

### 1. Installing WSL2
Follow this [tutorial](https://youtu.be/153iaHqYuIs?si=XTkpU1RixdP1p3ac) **UNTIL** 2:34 or follow below steps to install WSL2.

- Open a command terminal as administrator.
- Run `wsl --install` when completed restart your computer.
- In **Start** search for Ubuntu and open.
- You will be prompted to set up a user. Remember your username and password!
- Update ubuntu, run the following commands:
```
sudo apt update
sudo apt upgrade
```
- next install essential packages:
```
sudo apt install build-essential curl file git git-core
```
- install ohmyzsh (optional)
```
sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)"
```

### 2. Installing Docker
- Install [Docker](https://docs.docker.com/desktop/wsl/)
- Make sure to enable the WSL engine. (Default enabled if WSL2 is supported)
- You can enable WSL engine under **Settings -> General** in the Docker Desktop app.
- You can install Docker normally if using Mac or Linux.

### 3. Setting up development environment.
1. open WSL (Start -> type Ubuntu)
2. Clone git repository:
```
git clone https://github.com/Urban-Reef/Sensor-Reef-Web.git
```
3. Move into the cloned repo:
```
cd Sensor-Reef-Web
```
4. Install composer dependencies (make sure composer desktop is running):
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```
5. You should now be able to start and stop the application. To start the application run:
```
./vendor/bin/sail up -d
```
This will create docker containers. **NOTE**: On first run Docker will set up all the environments with the credentials as defined in the `.env` file.
If no file is set it will create a default `.env` file. To set your own passwords copy `.env.example` and fill in your preferred credentials.

Next run:
```
./vendor/bin/sail npm run start
```
This will start vite and enable the front-end.
The application should now be available from `localhost`

6. To stop the application run:
```
./vendor/bin/sail down
```

### Configure shell alias (optional)
1. go back to home
```
cd
```
2. open `.zshrc`
```
sudo nano .zshrc
```
3. Paste the following at the bottom of the file and save changes:
```
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```
4. You can now run sail directly by typing `sail`. This only works directly in the project folder!

### Documentation
For more information see the official documentation:
- [Installing Sail](https://laravel.com/docs/11.x/installation#docker-installation-using-sail)
- [Laravel Sail](https://laravel.com/docs/11.x/sail)

### Using IDE's
PHPStorm and Visual Studio Code will automatically open a wsl terminal when opening the project folder.
Installing a editor into the WSL environment is not necessary. Additionally, you can use vscode's remote development feature.
