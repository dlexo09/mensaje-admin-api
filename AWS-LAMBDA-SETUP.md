# Guía paso a paso para subir la función Lambda a AWS

## ✅ **Sí, el código está listo para AWS Lambda**

El archivo `lambda-function-example.js` está optimizado y listo para subir a AWS Lambda. Aquí te explico cómo hacerlo:

## 📋 **Prerequisitos**

1. Cuenta de AWS activa
2. Permisos para crear funciones Lambda y API Gateway
3. AWS CLI instalado (opcional pero recomendado)

## 🚀 **Método 1: Consola de AWS (Más fácil)**

### Paso 1: Crear la función Lambda

1. Ve a la **Consola de AWS** → **Lambda**
2. Clic en **"Crear función"**
3. Selecciona **"Crear desde cero"**
4. Configuración:
   - **Nombre de función**: `call-center-promotional-text`
   - **Runtime**: `Node.js 18.x` o `Node.js 20.x`
   - **Arquitectura**: `x86_64`
   - **Permisos**: Crear un nuevo rol con permisos básicos

### Paso 2: Subir el código

1. En el editor de código de Lambda
2. Borra el código por defecto
3. Copia y pega todo el contenido de `lambda-function-example.js`
4. Clic en **"Deploy"**

### Paso 3: Configurar API Gateway

1. Ve a **API Gateway** en la consola AWS
2. Clic en **"Crear API"**
3. Selecciona **"HTTP API"** → **"Build"**
4. Configuración:
   - **Nombre**: `call-center-api`
   - **Descripción**: `API para textos promocionales`

### Paso 4: Crear la ruta

1. En tu API, ve a **"Routes"**
2. Clic en **"Create"**
3. Configuración:
   - **Método**: `GET`
   - **Ruta**: `/promotional-text`
   - **Integración**: Lambda function
   - **Función**: Selecciona tu función `call-center-promotional-text`

### Paso 5: Configurar CORS

1. Ve a **"CORS"**
2. Clic en **"Configure"**
3. Configuración:
   - **Access-Control-Allow-Origin**: `*` (o tu dominio específico)
   - **Access-Control-Allow-Headers**: `Content-Type, Authorization`
   - **Access-Control-Allow-Methods**: `GET, OPTIONS`

### Paso 6: Deploy y obtener URL

1. Ve a **"Deploy"**
2. Crea un nuevo **Stage** llamado `prod`
3. Copia la **Invoke URL** que aparece
4. Tu URL final será algo como: `https://abc123.execute-api.us-east-1.amazonaws.com/prod/promotional-text`

## 🚀 **Método 2: AWS CLI (Avanzado)**

```bash
# 1. Comprimir el código
zip function.zip lambda-function-example.js

# 2. Crear la función
aws lambda create-function \
  --function-name call-center-promotional-text \
  --runtime nodejs18.x \
  --role arn:aws:iam::YOUR-ACCOUNT:role/lambda-execution-role \
  --handler lambda-function-example.handler \
  --zip-file fileb://function.zip

# 3. Crear API Gateway y configurar rutas
# (Comandos más complejos - recomiendo usar la consola)
```

## 🔧 **Configuración en tu proyecto**

Una vez que tengas la URL, actualiza `index.html`:

```javascript
const LAMBDA_API_URL = 'https://tu-api-id.execute-api.region.amazonaws.com/prod/promotional-text';
```

## 🧪 **Probar la función**

### Desde la consola AWS:
1. Ve a tu función Lambda
2. Clic en **"Test"**
3. Crea un nuevo evento de prueba:

```json
{
  "httpMethod": "GET",
  "queryStringParameters": null,
  "headers": {
    "Content-Type": "application/json"
  }
}
```

### Desde tu navegador:
Visita la URL directamente: `https://tu-api-url/promotional-text`

### Respuesta esperada:
```json
{
  "text": "¡Tengo una Mega noticia! Hoy tiene la oportunidad de activar MAX de 149 pesos, a tan solo 60 pesos al mes durante 6 meses. ¿Desea aprovechar esta promoción exclusiva?",
  "timestamp": "2025-07-08T10:30:00.000Z",
  "version": "1.0",
  "campaign_id": "MAX_PROMO_2025",
  "selected_index": 0,
  "total_options": 4,
  "request_id": "12345678-1234-1234-1234-123456789012"
}
```

## 💰 **Costos estimados**

- **Lambda**: Primeras 1M invocaciones gratis al mes
- **API Gateway**: Primeras 1M llamadas gratis al mes
- Para un call center típico: **< $1 USD/mes**

## 🔍 **Monitoreo**

1. **CloudWatch Logs**: Ve a Lambda → Monitor → View logs in CloudWatch
2. **Métricas**: Invocaciones, errores, duración
3. **Alertas**: Configura alertas si hay muchos errores

## ⚠️ **Notas importantes**

1. **Seguridad**: En producción, cambia `'*'` por tu dominio específico en CORS
2. **Cache**: Considera agregar cache con CloudFront para mejor rendimiento
3. **Límites**: Lambda tiene timeout de 15 minutos máximo (más que suficiente)
4. **Escalabilidad**: Lambda escala automáticamente

## 🆘 **Troubleshooting**

### Error CORS:
- Verifica que CORS esté configurado en API Gateway
- Asegúrate de que la función maneje OPTIONS

### Error 502:
- Revisa los logs en CloudWatch
- Verifica que la función retorne el formato correcto

### No se conecta:
- Verifica la URL en `index.html`
- Prueba la URL directamente en el navegador
