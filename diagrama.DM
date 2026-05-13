================================================================================
 DIAGRAMA DE MÓDULOS (DM) — SistemaOF v3.0
 Generado: 2026-05-12
 Estilo: Flat Modern Design Compacto (ref: Dropbox, Stripe, Rocket Money)
================================================================================

================================================================================
 VISIÓN GENERAL
================================================================================

  SistemaOF es un sistema administrativo modular para gestión de proyectos de
  construcción, remodelación y servicios. Desarrollado en PHP con arquitectura
  MVC, base de datos MySQL/MariaDB. Diseño UI compacto y moderno.

  Empresas operadoras:
  ├── SERVICIOS DE CONSTRUCCION O&F S. DE R.L.
  └── PINTER S. DE R.L.

================================================================================
 ARQUITECTURA MVC
================================================================================

  ┌─────────────────────────────────────────────────────────────┐
  │                        CLIENTE (Browser)                    │
  └────────────────────────────┬────────────────────────────────┘
                               │ HTTP Request
  ┌────────────────────────────▼────────────────────────────────┐
  │                         ROUTES                              │
  │          /login  /dashboard  /proyectos  /compras ...       │
  └────────────────────────────┬────────────────────────────────┘
                               │
  ┌────────────────────────────▼────────────────────────────────┐
  │                       MIDDLEWARE                            │
  │         Autenticación → Autorización → Rate Limit           │
  └────────────────────────────┬────────────────────────────────┘
                               │
  ┌────────────────────────────▼────────────────────────────────┐
  │                      CONTROLLERS                            │
  │  AuthController  │  ProyectoController  │  CompraController │
  │  ClienteCtrl     │  CotizaController    │  PlanillaCtrl     │
  └──────┬───────────────────────────────────────┬──────────────┘
         │                                       │
  ┌──────▼──────────┐                  ┌─────────▼─────────────┐
  │    SERVICES     │                  │       POLICIES        │
  │ FinancieroSvc   │                  │  ProyectoPolicy       │
  │ AprobacionSvc   │                  │  CompraPolicy         │
  │ ReporteSvc      │                  │  PlanillaPolicy       │
  └──────┬──────────┘                  └───────────────────────┘
         │
  ┌──────▼──────────┐
  │     MODELS      │
  │  Proyecto       │
  │  Alcance        │
  │  Cotizacion     │
  │  OrdCompra      │
  │  Planilla       │
  └──────┬──────────┘
         │
  ┌──────▼──────────┐
  │   BASE DATOS    │
  │  MySQL/MariaDB  │
  │  sistemaof DB   │
  └─────────────────┘

================================================================================
 MÓDULOS DEL SISTEMA (16 módulos)
================================================================================

  MÓDULO 01 — SEGURIDAD
  ├── Usuarios (sof_users)
  ├── Roles (sof_roles)
  ├── Módulos (sof_modulos)
  ├── Acciones (sof_acciones)
  ├── Permisos (sof_role_permissions)
  ├── Relación Usuario-Rol (sof_user_roles)
  ├── Bitácora (sof_audit_logs)
  ├── Sesiones (sof_user_sessions)
  └── Recuperación de contraseña (sof_password_resets)

  MÓDULO 02 — DASHBOARD
  ├── KPIs de proyectos activos
  ├── Compras pendientes de aprobación
  ├── Cotizaciones recientes
  ├── Planillas recientes
  └── Actividad reciente del sistema

  MÓDULO 03 — CLIENTES
  ├── Listado de clientes (clientes)
  ├── Alta/edición de cliente
  ├── Control de saldos (saldo_ant, cargos, abonos, saldo_act)
  └── Historial de proyectos por cliente

  MÓDULO 04 — PROVEEDORES
  ├── Listado de proveedores (proveedores)
  ├── Alta/edición de proveedor
  ├── Control de saldos
  └── Historial de compras por proveedor

  MÓDULO 05 — EMPRESAS
  ├── Listado (empresas)
  └── Alta/edición de empresa

  MÓDULO 06 — INGENIEROS
  ├── Catálogo de ingenieros (ingenieros)
  ├── Alta/edición
  └── Asignación a proyectos

  MÓDULO 07 — LÍNEAS
  ├── Catálogo de líneas de servicio (lineas)
  │   ├── LINEA DE SERVICIO TABLA YESO
  │   ├── LINEA DE SERVICIO DE PINTURA
  │   ├── LINEA DE SERVICIO DE PULIDO
  │   ├── REMODELACION
  │   ├── IMPERMEABILIZACION
  │   ├── INFRAESTRUCTURA
  │   └── LIMPIEZA
  └── Control de costos por línea (det_lineas)
      ├── Costos directos / indirectos
      └── Estados T01-T12 / ADI_T01-T12:
          P=Pendiente  F=Finalizado  R=Revisión  B=Bloqueado

  MÓDULO 08 — PRODUCTOS Y SERVICIOS
  ├── Catálogo de productos (productos)
  ├── Tipos (tipos): Materiales / Mano de Obra
  ├── Mano de obra (mano_obra)
  └── Costos configurables (costos)
      ├── Directos: EPP, Limpieza, Imprevistos, Material
      └── Indirectos: Supervisión, Aislamiento,
                      Provisión Administrativa 10.7%, Logística

  MÓDULO 09 — PROYECTOS
  ├── Listado de proyectos (proyectos)
  ├── Creación y edición
  │   ├── Código de proyecto (COD_PROY)
  │   ├── Cliente asignado
  │   ├── Empresa ejecutora
  │   ├── Ingeniero responsable (hasta 3)
  │   ├── Fecha inicio / fin
  │   ├── Fecha real inicio / fin
  │   └── Dirección del proyecto
  └── Ficha maestra: acceso a todos los documentos del proyecto

  MÓDULO 10 — ALCANCES Y COSTOS
  ├── Alcances del proyecto (alcance)
  │   ├── Costos: material, mano de obra, otros, ISV, subtotal
  │   ├── Imprevistos
  │   ├── % Utilidad y valor utilidad
  │   └── Precio y oferta: subtotal, ISV, total
  ├── Detalle de alcance (det_alcance)
  └── Detalle de costos (det_costos)

  MÓDULO 11 — COTIZACIONES
  ├── Encabezado (cotiza)
  │   ├── Código, proyecto, línea, cliente
  │   ├── Subtotal, descuento, ISV, total
  │   └── Estado facturado (Si/No)
  └── Detalle (det_cotiza)
      ├── Ítems por producto
      └── Cantidad, precio, descuento, ISV, total

  MÓDULO 12 — COMPRAS
  ├── Registro de compras (compras)
  ├── Órdenes de compra (ord_compras)
  │   ├── Estado: Pendiente / Aprobada / Anticipo / Cancelada
  │   ├── Forma pago: Contado / Crédito
  │   └── Aprobación con nombre, fecha y solicitante
  └── Detalle (det_ocompra)
      ├── Cantidades: pedida, recibida, pendiente, usada, actual
      └── Estado ítem: Pendiente / Anticipo / Completo

  MÓDULO 13 — ENTREGAS
  ├── Órdenes de entrega (orden_entrega)
  └── Detalle de entrega (det_oentrega)

  MÓDULO 14 — PLANILLAS
  ├── Encabezado (planilla): cuenta bancaria, total, autorizador
  └── Detalle (det_planilla): trabajador, descripción, valor

  MÓDULO 15 — REPORTES
  ├── Por proyecto, cliente, proveedor, compras, planillas
  └── Exportación PDF / Excel

  MÓDULO 16 — CONFIGURACIÓN
  ├── Parámetros (sof_configuracion)
  ├── Cuentas bancarias (cuentas_bank)
  └── Tipos de movimiento (tip_movtos)

================================================================================
 MODELO RBAC — SEGURIDAD
================================================================================

  sof_users ──N:N── sof_user_roles ──N:N── sof_roles
  sof_roles ──N:N── sof_role_permissions ──N:N── sof_modulos
  sof_role_permissions ──N── sof_acciones

  Roles:    Superadmin · Gerencia · Administrador · Compras
            Ingeniería · Finanzas · Cotizaciones · Consulta

  Acciones: VER · CREAR · EDITAR · ELIMINAR · APROBAR
            IMPRIMIR · EXPORTAR · ANULAR · CERRAR · REABRIR

  Matriz de permisos:
  ┌───────────────────┬────────┬─────────┬───────┬─────────┬──────────┬──────────┬────────────┬─────────┐
  │ Módulo            │Superadm│Gerencia │Admin  │Compras  │Ingeniería│Finanzas  │Cotizaciones│Consulta │
  ├───────────────────┼────────┼─────────┼───────┼─────────┼──────────┼──────────┼────────────┼─────────┤
  │ Dashboard         │ Total  │ Total   │ Total │ Parcial │ Parcial  │ Parcial  │ Parcial    │ Lectura │
  │ Seguridad         │ Total  │ Lectura │Parcial│ No      │ No       │ No       │ No         │ No      │
  │ Clientes          │ Total  │ Total   │ Total │ Lectura │ Lectura  │ Lectura  │ Lectura    │ Lectura │
  │ Proveedores       │ Total  │ Total   │ Total │ Total   │ Lectura  │ Lectura  │ Lectura    │ Lectura │
  │ Empresas          │ Total  │ Lectura │Parcial│ No      │ No       │ No       │ No         │ No      │
  │ Ingenieros        │ Total  │ Lectura │ Total │ Lectura │ Total    │ No       │ No         │ Lectura │
  │ Líneas            │ Total  │ Lectura │ Total │ Lectura │ Total    │ No       │ Parcial    │ Lectura │
  │ Productos         │ Total  │ Lectura │ Total │ Lectura │ Lectura  │ No       │ Lectura    │ Lectura │
  │ Proyectos         │ Total  │ Total   │ Total │ Lectura │ Total    │ Lectura  │ Lectura    │ Lectura │
  │ Alcances          │ Total  │ Total   │ Total │ Lectura │ Total    │ Lectura  │ Parcial    │ Lectura │
  │ Cotizaciones      │ Total  │ Total   │ Total │ Lectura │ Parcial  │ Lectura  │ Total      │ Lectura │
  │ Compras           │ Total  │ Aprob.  │ Total │ Total   │Solicitud │ Lectura  │ No         │ Lectura │
  │ Entregas          │ Total  │ Lectura │ Total │ Total   │ Lectura  │ No       │ No         │ Lectura │
  │ Planillas         │ Total  │ Aprob.  │Parcial│ No      │ Lectura  │ Total    │ No         │ Lectura │
  │ Reportes          │ Total  │ Total   │ Total │ Parcial │ Parcial  │ Parcial  │ Parcial    │ Lectura │
  │ Configuración     │ Total  │ No      │Parcial│ No      │ No       │ No       │ No         │ No      │
  └───────────────────┴────────┴─────────┴───────┴─────────┴──────────┴──────────┴────────────┴─────────┘

================================================================================
 FLUJO PRINCIPAL DEL NEGOCIO
================================================================================

  [CLIENTE]
      │
      ▼
  [PROYECTO] ──► [ALCANCES + COSTOS] ──► [COTIZACIÓN] ──► [CLIENTE]
      │
      ├──► [ÓRDENES DE COMPRA] ──► [APROBACIÓN] ──► [PROVEEDOR]
      │              └──► [ENTREGAS]
      │
      ├──► [PLANILLAS DE PAGO] ──► [CUENTAS BANCARIAS]
      │
      └──► [REPORTES]

================================================================================
 FASES DE DESARROLLO
================================================================================

  FASE 1 — Núcleo y Seguridad
  FASE 2 — Catálogos y Maestros
  FASE 3 — Proyectos y Operaciones
  FASE 4 — Documentos Comerciales y Compras
  FASE 5 — Finanzas y Reportes

================================================================================
 DATOS INICIALES
================================================================================

  Empresas: 2 | Clientes: 25 | Proveedores: 5 | Ingenieros: 8
  Líneas: 7 | Productos: 21 | Cuentas bancarias: 6
  Moneda: HNL | ISV: 15%

================================================================================
 FIN DEL DOCUMENTO — SistemaOF DM v3.0
================================================================================