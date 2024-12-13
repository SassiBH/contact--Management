# Step 1: Build the Vue.js Application
FROM node:16 AS build-stage

# Set the working directory in the container
WORKDIR /app

# Copy package.json and package-lock.json
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy the entire application to the container
COPY . .

# Build the Vue app for production
RUN npm run build

# Step 2: Serve with Nginx
FROM nginx:alpine

# Copy the built Vue.js files from the previous stage
COPY --from=build-stage /app/dist /usr/share/nginx/html

# Expose port 80 (Nginx default port)
EXPOSE 80

# Start Nginx in the foreground
CMD ["nginx", "-g", "daemon off;"]
