# php-app

مشروع تطبيقي باستخدام PHP + MySQL + phpMyAdmin مع النشر على Google Kubernetes Engine (GKE).

---

## 📅 وصف المشروع
تطبيق ويب بسيط يتيح للمستخدمين تسجيل الدخول والتسجيل باستخدام قاعدة بيانات MySQL. تمت إدارة قاعدة البيانات عبر phpMyAdmin، وتم نشر المشروع على Google Cloud Platform باستخدام Kubernetes.

---

## 📂 هيكل الملفات
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
│   ├── db.php
│   └── styles.css
├── k8s/
│   ├── mysql-deployment.yaml
│   ├── mysql-service.yaml
│   ├── php-deployment.yaml
│   ├── php-service.yaml
│   ├── phpmyadmin.yaml
│   ├── phpmyadmin-service.yaml
│   └── init-sql-configmap.yaml
```

---

## ⚙️ المتطلبات المسبقة
- حساب Google Cloud Platform
- تفعيل Kubernetes Engine API
- تنصيب Google Cloud SDK
- تهيئة CLI:
```bash
gcloud init
gcloud auth login
gcloud config set project <project-id>
gcloud config set compute/zone <your-zone>
```

---

## 🚀 خطوات النشر على Google Kubernetes Engine

### ✅ 1. إنشاء Cluster:
```bash
gcloud container clusters create-auto php-app-cluster --region us-central1
```

### ✅ 2. تحميل بيانات الاعتماد:
```bash
gcloud container clusters get-credentials php-app-cluster --region us-central1
```

### ✅ 3. إنشاء ConfigMap لملف init.sql:
```bash
kubectl create configmap init-sql-config \
  --from-file=scripts/init.sql
```

### ✅ 4. تطبيق جميع ملفات Kubernetes:
```bash
kubectl apply -f k8s/
```

### ✅ 5. التحقق من الحالة:
```bash
kubectl get pods
kubectl get services
```

---

## 📶 روابط الوصول (بعد النشر)
- تطبيق PHP: `http://<EXTERNAL-IP-of-php-service>`
- phpMyAdmin: `http://<EXTERNAL-IP-of-phpmyadmin-service>`

يمكن الحصول على الروابط عبر الأمر:
```bash
kubectl get svc
```

---

## 📁 شرح الملفات المهمة

### Dockerfile
يحدد بيئة تشغيل PHP وتشغيل التطبيق من مجلد `src/`

### docker-compose.yml
يستخدم لتشغيل البيئة محليًا (PHP + MySQL + phpMyAdmin) لتجربة المشروع قبل النشر.

### scripts/init.sql
ملف SQL لتهيئة قاعدة البيانات (إنشاء الجداول، إضافة بيانات أولية...)

### ملفات k8s/
تحتوي على تعريفات `Deployment` و `Service` لتشغيل كل من:
- MySQL
- تطبيق PHP
- phpMyAdmin

---

## 🛠️ ملاحظات
- تمت مراعاة متطلبات GKE Autopilot بإضافة resources (CPU/Memory).
- يمكن ربط التطبيق بدومين مجاني لاحقًا باستخدام DNS.
- تم استخدام صور رسمية من Docker Hub لتبسيط النشر.

---

## 🎓 للاستخدام الأكاديمي فقط
تم إعداد هذا المشروع لغرض دراسي وتعليمي، ويمكن استخدامه كنموذج لمشاريع النشر السحابي.

---

بالتوفيق في عرضك! 🚀
