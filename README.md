# 📊 MetriTask – Backend

Este proyecto es el backend de **MetriTask**, una plataforma de gestión de proyectos y tareas colaborativas. Está construido con **Laravel** y usa **Filament** como panel administrativo. Incluye estadísticas, gestión de usuarios, control de roles y permisos, y componentes personalizados.

---

## 🧠 Funcionalidades principales

- Gestión de **Proyectos**, **Tareas** y **Usuarios**
- Asignación de tareas a usuarios
- Panel administrativo con widgets de estadísticas
- Control de acceso mediante **roles y permisos**
- Sistema de prioridades y estados de tareas
- Estadísticas visuales con **gráficos**

---

## 🔐 Roles y permisos

Integrado con `spatie/laravel-permission`.

### Roles definidos:

- `admin`
- `manager`
- `member`

### Permisos disponibles:

- `view projects`, `create projects`, `edit projects`, `delete projects`
- `view tasks`, `create tasks`, `edit tasks`, `delete tasks`
- `assign tasks`
- `view users`, `create users`, `edit users`, `delete users`
- `admin panel`

Los permisos se usan en conjunto con políticas de acceso en Filament.

---

## 📁 Estructura general

### Filament Resources:

- `ProjectResource` → CRUD de proyectos
- `TaskResource` → CRUD de tareas
- `UserResource` → Gestión de usuarios

  ![projects](https://github.com/user-attachments/assets/c70cc53c-a01e-45d9-a3d9-ccd3f98afb3d)
![urser](https://github.com/user-attachments/assets/2a9a8ab9-d72d-4cb8-b037-d9a966d75d61)
![task](https://github.com/user-attachments/assets/26b966aa-ee3c-49f5-9dcd-8f99ef17c830)


### Filament Widgets:

- `ProjectStatsOverview` → Estadísticas generales:

  - Proyectos totales
  - Tareas completadas / pendientes
  - Usuarios registrados
  - Tareas asignadas
- `ProjectChart` → Gráfico de barras:

  - Comparativa tareas completadas vs pendientes
-  `LineChart` → Crecimiento de proyectos diarios
  
---

## 📊 Estadísticas del dashboard

El dashboard principal incluye un resumen de métricas:

- Total de proyectos
- Tareas completadas
- Tareas pendientes
- Total de usuarios
- Tareas asignadas

Además, pueden mostrarse **gráficos dinámicos** utilizando los widgets de charts de Filament para representar visualmente los datos.

![dashboard](https://github.com/user-attachments/assets/d6bfedc5-aa80-479d-a7b2-6d3f5cb13500)
---

## 🧩 Dependencias principales

- **Laravel** (framework base)
- **Filament** (panel administrativo)
- **Spatie Laravel-Permission** (gestión de roles y permisos)
- **Filament Widgets & Charts** (para mostrar estadísticas)
- **PostgreSQL** (base de datos usada)

---

## 📌 Detalles extra

- Los estados de tareas pueden ser: `pending`, `in_progress`, `completed`
- Las prioridades pueden ser: `low`, `medium`, `high`
- Los proyectos y tareas están relacionados, con opciones de asignar tareas a usuarios
- El panel Filament se adapta según el rol y permisos del usuario autenticado

---

## ✍️ Autor

@alexgg9
