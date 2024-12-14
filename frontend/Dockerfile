# Step 1: Build the Vue.js Application
FROM node:20 AS build-stage

# Set the working directory in the container
WORKDIR /app

# Copy package.json and package-lock.json
COPY package*.json ./

# Install dependencies
RUN npm install -g npm@10.9.2

# Copy the entire application to the container
COPY . .

# Build the Vue app for production
RUN npm run build

# Step 2: Serve with Nginx
FROM nginx:alpine

COPY nginx.conf /etc/nginx/nginx.conf

# Copy the built Vue.js files from the previous stage
COPY --from=build-stage /app/dist /usr/share/nginx/html

COPY nginx.conf /etc/nginx/nginx.conf

# Expose port 80 (Nginx default port)
EXPOSE 80

# Start Nginx in the foreground
CMD ["nginx", "-g", "daemon off;"]
