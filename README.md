# Contact Management


![Project Logo](https://industryx0.pro/wp-content/uploads/2021/01/cropped-Logo-AI-V1.png)

Simple web application for contact CRUD implementation whith authentification, using PHP for backend , VueJs for frontend and MySQL for database.


[![My Skills](https://skillicons.dev/icons?i=php,vue,mysql,docker,tailwind,nodejs,postman)](https://skillicons.dev)

---

## Table of Contents

- 🔨 [Installation](#installation)
- 🌐 [Usage](#usage)




---



## 🔨 Installation

### Prerequisites

Before you begin, ensure you have met the following requirements:

- Docker
- NodeJs > v20
- Composer
- Vue Cli 

### Steps to Install

1. Clone the repository:
   ```bash
   git clone https://github.com/SassiBH/contact--Management.git

2. Open the project folder:
    ```bash
    cd contact--Management
3. Install backend dependencies:
    ```bash
    cd backend
    composer install
4. Open new terminal and Install frontend dependencies:
    ```bash
    cd frontend
    npm install
5. Open new terminal and build the  docker application
      ```bash
       docker-compose build
       docker-compose up

## 🌐 Usage

1. Start docker application
    ```bash
    docker-compose up
2. Open the url for application in browser
    - http://localhost:8100/ for build version
    - http://localhost:8080/ for develop version
3. To stop the application use the command
    ```bash
    docker compose stop
4. If you make an update to the frontend, rebuild the application to apply the changes using this command
    ```bash
    docker-compose build