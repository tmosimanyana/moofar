#!/bin/bash

# Use the folder where the script is located
cd "$(dirname "$0")" || exit

# Install Vercel CLI if missing
if ! command -v vercel &> /dev/null; then
    echo "Installing Vercel CLI..."
    npm install -g vercel
fi

# Login check
if ! vercel whoami &> /dev/null; then
    echo "Logging into Vercel..."
    vercel login
fi

# Deploy to Vercel
echo "Deploying to Vercel..."
vercel --prod --yes

echo "✅ Deployment finished!"
