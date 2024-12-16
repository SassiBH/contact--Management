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
- NodeJs >= v20
- Composer
- Vue Cli 
- PHP >= 8.1

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
6. Create .enc file in the backend folder with the following keys and values 
    ```bash
    DB_HOST=db
    DB_NAME=contactManager
    DB_CHARSET=utf8mb4
    DB_USER=root
    DB_PASS=secret
    JWT_SECRET= your_key
    JWT_ISSUER= ${process.env.VUE_APP_API_URL}
## 🌐 Usage

1. Start docker application
    ```bash
    docker-compose up
2. To stop the application use the command
    ```bash
    docker compose stop
3. For production version open the url for application in browser(needs server refresh)
    - http://localhost:8100/

4. For devoloper version run this commands  and visit http://localhost:8081/
    ```bash
    cd frontend
    docker-compose build
