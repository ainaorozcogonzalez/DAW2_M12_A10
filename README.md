# 🚀 Sistema de Gestión de Incidencias Informáticas


## 📌 Descripción

Este proyecto es una plataforma web para la **gestión centralizada de incidencias informáticas** en una multinacional con sedes en **Barcelona, Berlín y Montreal**. La aplicación permite al personal registrar, gestionar y resolver incidencias de manera eficiente.

---

## 🎯 Características Principales

✅ **Diseño Responsive** 📱💻

✅ **Sistema de Autenticación Segura** 🔐

✅ **Gestión de Incidencias con Estados** 📊

✅ **Diferentes Roles de Usuario** 👥

✅ **Filtros y Búsquedas Avanzadas** 🔍

✅ **Notificaciones y Mensajes** 📩

✅ **Carga de Imágenes para Mejor Diagnóstico** 🖼️

✅ **Interfaz Intuitiva y Moderna** 🎨

---

## 👤 Roles de Usuario

| Rol                | Descripción |
|-------------------|-------------|
| **Administrador**  | Gestiona usuarios y tipos de incidencias. |
| **Cliente**       | Reporta incidencias y da seguimiento. |
| **Gestor de Equipo** | Asigna incidencias y establece prioridades. |
| **Técnico de Mantenimiento** | Resuelve incidencias y cambia su estado. |

---

## 🔥 Estados de las Incidencias

- ⏳ **Sin Asignar** → Registrada pero sin asignación.
- 📌 **Asignada** → Se ha asignado a un técnico.
- 🔧 **En Trabajo** → Se está resolviendo la incidencia.
- ✅ **Resuelta** → El técnico ha finalizado la tarea.
- 🔒 **Tancada** → Confirmación de resolución.

---

## 🛠️ Tecnologías Utilizadas

- **Framework:** Laravel ⚡
- **Lenguaje:** PHP 🐘
- **Base de Datos:** MySQL 🗄️
- **Frontend:** Blade Templates, HTML5, CSS3, JavaScript 🎨
- **Control de Versiones:** Git 🛠️

---

## 📥 Instalación y Configuración

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/ainaorozcogonzalez/DAW2_M12_A10.git
   ```

2. **Instalar dependencias**
   ```bash
   composer install
   ```

3. **Configurar el entorno**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrar la base de datos**
   ```bash
   php artisan migrate --seed
   ```

5. **Levantar el servidor**
   ```bash
   php artisan serve
   ```
   📌 La aplicación estará disponible en: `http://localhost:8000`

---

## 🚀 Uso de la Aplicación

🔹 **Administrador:** Gestiona usuarios y incidencias.

🔹 **Cliente:** Reporta y consulta incidencias.

🔹 **Gestor de Equipo:** Asigna y prioriza incidencias.

🔹 **Técnico de Mantenimiento:** Resuelve y actualiza el estado de las incidencias.

---

## 🤝 Contribuciones

¡Las contribuciones son bienvenidas! 🚀

1. Haz un **fork** del repositorio.
2. Crea una nueva **rama** (`feature/nueva-funcionalidad`).
3. Realiza los cambios y haz **commit**.
4. Envía un **pull request** detallado.

---

## 📄 Licencia

📝 Este proyecto está bajo la **Licencia MIT**. Consulta el archivo `LICENSE` para más información.

---

## 📚 Recursos Adicionales

📖 [Documentación de Laravel](https://laravel.com/docs)

💬 **¿Dudas o sugerencias?** No dudes en contactar o abrir un **issue** en el repositorio. 😊
