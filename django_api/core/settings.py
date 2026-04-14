"""
Configuración de Django para el proyecto crud_clientes API.
Lee credenciales desde variables de entorno (definidas en docker-compose.yml).
"""

import os
from pathlib import Path

BASE_DIR = Path(__file__).resolve().parent.parent

# ─────────────────────────────────────────
# Seguridad
# ─────────────────────────────────────────
SECRET_KEY = 'django-insecure-cambia-esta-clave-en-produccion-abc123xyz'

# En producción: DEBUG=False y ajustar ALLOWED_HOSTS
DEBUG = os.environ.get('DEBUG', 'True') == 'True'

ALLOWED_HOSTS = ['*']   # En producción restringe a tu dominio

# ─────────────────────────────────────────
# Aplicaciones instaladas
# ─────────────────────────────────────────
INSTALLED_APPS = [
    'django.contrib.admin',
    'django.contrib.auth',
    'django.contrib.contenttypes',
    'django.contrib.sessions',
    'django.contrib.messages',
    'django.contrib.staticfiles',

    # Terceros
    'rest_framework',       # Django REST Framework
    'corsheaders',          # CORS para que el frontend PHP pueda consumir la API

    # Nuestras apps
    'api',
]

MIDDLEWARE = [
    'corsheaders.middleware.CorsMiddleware',   # debe ir primero
    'django.middleware.security.SecurityMiddleware',
    'django.contrib.sessions.middleware.SessionMiddleware',
    'django.middleware.common.CommonMiddleware',
    'django.middleware.csrf.CsrfViewMiddleware',
    'django.contrib.auth.middleware.AuthenticationMiddleware',
    'django.contrib.messages.middleware.MessageMiddleware',
    'django.middleware.clickjacking.XFrameOptionsMiddleware',
]

ROOT_URLCONF = 'core.urls'

TEMPLATES = [
    {
        'BACKEND': 'django.template.backends.django.DjangoTemplates',
        'DIRS': [],
        'APP_DIRS': True,
        'OPTIONS': {
            'context_processors': [
                'django.template.context_processors.debug',
                'django.template.context_processors.request',
                'django.contrib.auth.context_processors.auth',
                'django.contrib.messages.context_processors.messages',
            ],
        },
    },
]

WSGI_APPLICATION = 'core.wsgi.application'

# ─────────────────────────────────────────
# Base de datos MySQL (misma que usa PHP)
# Credenciales vienen de docker-compose.yml
# ─────────────────────────────────────────
DATABASES = {
    'default': {
        'ENGINE':   'django.db.backends.mysql',
        'NAME':     os.environ.get('DB_NAME',     'crud_clientes'),
        'USER':     os.environ.get('DB_USER',     'nuevo'),
        'PASSWORD': os.environ.get('DB_PASSWORD', 'nuevo123'),
        'HOST':     os.environ.get('DB_HOST',     'db'),
        'PORT':     os.environ.get('DB_PORT',     '3306'),
        'OPTIONS': {
            'charset': 'utf8mb4',
        },
    }
}

# ─────────────────────────────────────────
# Django REST Framework
# ─────────────────────────────────────────
REST_FRAMEWORK = {
    # Respuestas en JSON por defecto (sin formularios HTML en el navegador)
    'DEFAULT_RENDERER_CLASSES': [
        'rest_framework.renderers.JSONRenderer',
    ],
    # Parsear body JSON en POST/PUT
    'DEFAULT_PARSER_CLASSES': [
        'rest_framework.parsers.JSONParser',
    ],
}

# ─────────────────────────────────────────
# CORS — permite que el frontend PHP en
# localhost:8080 llame a la API en :8000
# ─────────────────────────────────────────
CORS_ALLOW_ALL_ORIGINS = True   # En producción: listar solo tus dominios

# ─────────────────────────────────────────
# Internacionalización
# ─────────────────────────────────────────
LANGUAGE_CODE = 'es-co'
TIME_ZONE     = 'America/Bogota'
USE_I18N      = True
USE_TZ        = True

STATIC_URL = '/static/'

DEFAULT_AUTO_FIELD = 'django.db.models.BigAutoField'
