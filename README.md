
# php-app

A practical project using PHP + MySQL + phpMyAdmin with deployment via Docker, Kubernetes, and Google Kubernetes Engine (GKE).

---

## 📌 Project Description
A simple web application that allows users to register and log in using a MySQL database. The database is managed via phpMyAdmin. The project was tested locally with Docker, deployed on Kubernetes, and finally hosted on Google Cloud Platform using GKE.

---

## 📁 Project Structure
```bash
php-app/
├── Dockerfile
├── docker-compose.yml
├── scripts/
│   └── init.sql
├── src/
│   ├── index.php
│   ├── login.php
│   ├── register.php
│   └── styles.css
├── k8s/
│   ├── mysql-deployment.yaml
│   ├── mysql-service.yaml
│   ├── mysql-configmap.yaml
│   ├── php-service.yaml
│   ├── php-deployment.yaml
│   ├── phpmyadmin-service.yaml
│   └── phpmyadmin.yaml
```

---

## 🐳 Run the Project Locally with Docker

### ✅ 1. Build and run the services:
```bash
docker-compose up --build
```

### ✅ 2. Access the services:
- PHP App: [http://localhost:8080](http://localhost:8080)
- phpMyAdmin: [http://localhost:8081](http://localhost:8081)

### ✅ 3. Database Login:
- **Host**: `mysql`
- **Username**: `myuser`
- **Password**: `mypassword`

---

## ☸️ Run the Project Locally with Kubernetes (via Docker Desktop)

### ✅ 1. Make sure Kubernetes is enabled in Docker Desktop.

### ✅ 2. Create a ConfigMap for the init.sql file:
```bash
kubectl create configmap mysql-configmap --from-file=scripts/init.sql
```

### ✅ 3. Apply the manifests:
```bash
kubectl apply -f k8s/
```

### ✅ 4. Check the status:
```bash
kubectl get pods
kubectl get services
```

### ✅ 5. Access the services:
- Use `kubectl port-forward` or set services to `NodePort` for local access.

---

## ☁️ Deploy the Project on Google Kubernetes Engine (GKE)

### ⚙️ Prerequisites:
- Google Cloud Platform account
- Kubernetes Engine API enabled
- Google Cloud SDK installed
- kubectl installed

### ✅ Setup environment:
```bash
gcloud init
gcloud auth login
gcloud config set project <project-id>
gcloud config set compute/zone <your-zone>
```

### ✅ 1. Create the Cluster:
```bash
gcloud container clusters create-auto php-app-cluster --region us-central1
```

### ✅ 2. Get credentials:
```bash
gcloud container clusters get-credentials php-app-cluster --region us-central1
```

### ✅ 3. Create ConfigMap for init.sql:
```bash
kubectl create configmap mysql-configmap \
  --from-file=scripts/init.sql
```

### ✅ 4. Deploy the Kubernetes manifests:
```bash
kubectl apply -f k8s/
```

### ✅ 5. Check the status:
```bash
kubectl get pods
kubectl get services
```

---

## 🌐 Public Access (after deployment)
- PHP App: `http://<EXTERNAL-IP-of-php-service>`
- phpMyAdmin: `http://<EXTERNAL-IP-of-phpmyadmin-service>`

### Get External IP:
```bash
kubectl get svc
```

---

## 📂 Explanation of Key Files

### Dockerfile
Defines PHP runtime environment and copies application files from `src/`.

### docker-compose.yml
Runs the full stack (PHP, MySQL, phpMyAdmin) for local development.

### scripts/init.sql
Initial SQL script to set up the database schema and seed data.

### k8s/
Kubernetes manifests for deploying:
- MySQL
- PHP app
- phpMyAdmin

---

## 🧠 Technical Notes
- GKE Autopilot requires resource limits; apply `resources` for CPU/Memory.
- Official Docker images were used for simplicity and reliability.
- Use `.env` for sensitive configuration values in production.

---

## 🎓 For Academic Use Only
This project is prepared for educational purposes and can be reused as a cloud deployment sample.

---

Good luck! 🚀
