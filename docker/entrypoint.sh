#!/bin/sh
set -e

# Geração do .env a partir do template com variáveis de ambiente
echo "[entrypoint] Gerando .env a partir do template..."
envsubst < config.env.example.php > config.env.php

# Inicia o servidor — recebe o CMD do Dockerfile como argumento
echo "[entrypoint] Iniciando servidor: $*"
exec "$@"