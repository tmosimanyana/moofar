#!/bin/bash

# Step 0: Navigate to your project folder (update path if needed)
cd /path/to/your/moofar || exit

# Step 1: Check if Vercel CLI is installed
if ! command -v vercel &> /dev/null
then
    echo "Vercel CLI not found. Installing..."
    npm install -g vercel
else
    echo "Vercel CLI found."
fi

# Step 2: Pull latest changes from GitHub
echo "Pulling latest changes from GitHub..."
git pull https://github.com/tmosimanyana/moofar.git main

# Step 3: Add and commit any local changes
if [ -n "$(git status --porcelain)" ]; then
    echo "Committing local changes..."
    git add .
    git commit -m "Auto-commit: update project with latest changes"
    git push origin main
else
    echo "No local changes to commit."
fi

# Step 4: Deploy to Vercel
echo "Deploying to Vercel..."
vercel --prod --confirm

echo "✅ Deployment finished! Check https://moofar.vercel.app"
