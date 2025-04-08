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
