# Stage 1: Base Setup
FROM node:20 AS base

# Set working directory
WORKDIR /app

# Copy package.json and install dependencies
COPY package*.json ./
RUN npm install

# Copy the app source code
COPY . .

# Stage 2: Development
FROM base AS development

# Expose development server port
EXPOSE 8080

# Default command for development
CMD ["npm", "run", "serve"]

# Stage 3: Production Build
FROM base AS build

# Build the Vue.js app
RUN npm run build

# Stage 4: Nginx for Production
FROM nginx:alpine AS production

COPY nginx.conf /etc/nginx/nginx.conf
# Copy built files to Nginx's HTML directory
COPY --from=build /app/dist /usr/share/nginx/html

# Expose default Nginx port
EXPOSE 80

# Start Nginx
CMD ["nginx", "-g", "daemon off;"]
