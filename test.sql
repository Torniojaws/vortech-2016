SELECT photos.*, photo_albums.*, photo_categories.*
FROM photos
    JOIN photo_albums
        ON photo_albums.id = photos.album_id
    JOIN photo_categories
        ON photo_categories.id = photo_albums.category_id
WHERE photo_categories.name_id="promo"
