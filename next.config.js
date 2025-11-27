/** @type {import('next').NextConfig} */
const nextConfig = {
  async headers() {
    return [
      {
        source: '/(.*)', // all routes
        headers: [
          {
            key: 'X-Robots-Tag',
            value: process.env.VERCEL_ENV === 'production' ? 'index, follow' : 'noindex',
          },
        ],
      },
    ];
  },
};

module.exports = nextConfig;


