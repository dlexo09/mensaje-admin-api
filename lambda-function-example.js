// Función Lambda para AWS - Lista para producción
// Este código está optimizado para AWS Lambda con API Gateway

exports.handler = async (event, context) => {
    // Configurar headers CORS
    const headers = {
        'Access-Control-Allow-Origin': '*', // En producción, especifica tu dominio
        'Access-Control-Allow-Headers': 'Content-Type, Authorization',
        'Access-Control-Allow-Methods': 'GET, POST, OPTIONS',
        'Content-Type': 'application/json'
    };
    
    // Log para debugging en CloudWatch
    console.log('Event:', JSON.stringify(event, null, 2));
    console.log('Context:', JSON.stringify(context, null, 2));
    
    try {
        // Manejar preflight request (CORS)
        if (event.httpMethod === 'OPTIONS') {
            return {
                statusCode: 200,
                headers,
                body: ''
            };
        }
        
        // Validar método HTTP
        if (event.httpMethod !== 'GET') {
            return {
                statusCode: 405,
                headers,
                body: JSON.stringify({
                    error: 'Método no permitido',
                    message: 'Solo se permite GET'
                })
            };
        }
        
        // Aquí puedes obtener el texto desde una base de datos, 
        // archivo S3, DynamoDB, o cualquier otra fuente
        const promotionalTexts = [
            "¡Tengo una Mega noticia! Hoy tiene la oportunidad de activar MAX de 149 pesos, a tan solo 60 pesos al mes durante 6 meses. ¿Desea aprovechar esta promoción exclusiva?",
            "¡Oferta especial! Active MAX por solo 60 pesos al mes durante 6 meses. Precio regular: 149 pesos. ¿Le interesa esta promoción?",
            "¡Promoción limitada! MAX a precio especial: 60 pesos mensuales por 6 meses. ¿Quiere aprovechar esta oportunidad única?",
            "¡Última oportunidad! Paquete MAX con 60% de descuento: solo 60 pesos por 6 meses. ¿Acepta esta oferta exclusiva?"
        ];
        
        // Obtener parámetros de query si los hay (para personalización)
        const queryParams = event.queryStringParameters || {};
        const campaignId = queryParams.campaign || 'MAX_PROMO_2025';
        
        // Seleccionar texto aleatorio o basado en alguna lógica
        const randomIndex = Math.floor(Math.random() * promotionalTexts.length);
        const selectedText = promotionalTexts[randomIndex];
        
        // Log para monitoreo
        console.log(`Texto seleccionado (índice ${randomIndex}):`, selectedText);
        
        // También puedes incluir metadata adicional
        const response = {
            text: selectedText,
            timestamp: new Date().toISOString(),
            version: "1.0",
            campaign_id: campaignId,
            selected_index: randomIndex,
            total_options: promotionalTexts.length,
            request_id: context.awsRequestId
        };
        
        console.log('Respuesta exitosa:', response);
        
        return {
            statusCode: 200,
            headers,
            body: JSON.stringify(response)
        };
        
    } catch (error) {
        console.error('Error en Lambda:', error);
        
        return {
            statusCode: 500,
            headers,
            body: JSON.stringify({
                error: 'Error interno del servidor',
                message: error.message,
                request_id: context.awsRequestId,
                timestamp: new Date().toISOString()
            })
        };
    }
};

// Ejemplo de respuesta JSON que retorna la función:
/*
{
    "text": "¡Tengo una Mega noticia! Hoy tiene la oportunidad de activar MAX de 149 pesos, a tan solo 60 pesos al mes durante 6 meses. ¿Desea aprovechar esta promoción exclusiva?",
    "timestamp": "2025-07-08T10:30:00.000Z",
    "version": "1.0",
    "campaign_id": "MAX_PROMO_2025"
}
*/
