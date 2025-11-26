import fs from 'fs';
import path from 'path';

export default function handler(req, res) {
  const galleryPath = path.join(process.cwd(), 'assets'); // <-- use assets/

  fs.readdir(galleryPath, (err, files) => {
    if (err) {
      res.status(500).json({ error: 'Failed to read assets folder' });
      return;
    }

    // Only include image files
    const images = files.filter(file =>
      /\.(jpe?g|png|webp|gif)$/i.test(file)
    );

    res.status(200).json(images);
  });
}
