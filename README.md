# Product Recommendation System

A Laravel-based product recommendation system with an admin panel for managing products, merchants, and users. The system provides personalized product recommendations based on user interactions and browsing history.

## Features

### Public Features (No Login Required)
- **Product Browsing**: View all available products with filtering and search
- **Personalized Recommendations**: Get product suggestions based on browsing history
- **Product Details**: View detailed product information including merchant availability
- **Search & Filter**: Search products by name, description, brand, or category
- **Popular Products**: View most viewed and liked products
- **Latest Products**: Browse recently added products

### Admin Panel Features
- **Secure Login**: Admin authentication system
- **Dashboard**: Overview with statistics and quick actions
- **User Management**: Create and manage system users
- **Product Management**: Add, edit, delete, and import products
- **Merchant Management**: Manage product merchants and availability
- **Excel Import**: Import products from Excel/CSV files
- **Statistics**: View system statistics and user interactions

### Recommendation Engine
- **Session-based Tracking**: Track user interactions without requiring login
- **Category-based Recommendations**: Suggest products from similar categories
- **Brand-based Recommendations**: Recommend products from preferred brands
- **Popularity Fallback**: Show popular products when no personal data exists
- **Interaction Tracking**: Monitor views, likes, purchases, and shares

## Technology Stack

- **Backend**: Laravel 12.x
- **Database**: SQLite (default), MySQL/PostgreSQL supported
- **Frontend**: Bootstrap 5, jQuery
- **Icons**: Font Awesome 6
- **File Upload**: Laravel Storage
- **Excel Import**: Maatwebsite/Excel (to be implemented)

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Web server (Apache/Nginx) or PHP built-in server

### Setup Instructions

1. **Clone or download the project**
   ```bash
   cd recommendation-system
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   Edit `.env` file and set your database configuration:
   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=/absolute/path/to/database.sqlite
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Seed the database with sample data**
   ```bash
   php artisan db:seed
   ```

7. **Create storage link (for file uploads)**
   ```bash
   php artisan storage:link
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

## Default Credentials

After running the seeder, you can access the admin panel with:

- **URL**: `http://localhost:8000/admin/login`
- **Email**: `admin@Pharmacily.com`
- **Password**: `password`

## Database Structure

### Tables
- **users**: System users and admin accounts
- **products**: Product information and details
- **merchants**: Merchant/seller information
- **product_merchant**: Many-to-many relationship between products and merchants
- **user_interactions**: Track user behavior for recommendations

### Key Relationships
- Products ↔ Merchants (Many-to-Many)
- Products ↔ User Interactions (One-to-Many)
- Users ↔ User Interactions (One-to-Many)

## API Endpoints

### Public Routes
- `GET /` - Home page with recommendations
- `GET /products` - Product listing
- `GET /products/{id}` - Product details
- `GET /search` - Product search
- `POST /track-interaction/{id}` - Track user interaction

### Admin Routes
- `GET /admin/login` - Admin login page
- `POST /admin/login` - Admin authentication
- `GET /admin/dashboard` - Admin dashboard
- `GET /admin/products` - Product management
- `GET /admin/merchants` - Merchant management
- `GET /admin/users` - User management

## Recommendation Algorithm

The system uses a simple but effective recommendation algorithm:

1. **Session Tracking**: Track user interactions using session ID
2. **Category Analysis**: Analyze user's preferred categories
3. **Brand Analysis**: Identify preferred brands
4. **Similarity Matching**: Find products with similar attributes
5. **Popularity Fallback**: Use popular products when no personal data exists

### Future Enhancements
- Machine learning integration
- Collaborative filtering
- Content-based filtering
- A/B testing for recommendations

## File Structure

```
recommendation-system/
├── app/
│   ├── Http/Controllers/
│   │   ├── AdminController.php
│   │   ├── ProductController.php
│   │   └── RecommendationController.php
│   └── Models/
│       ├── Product.php
│       ├── Merchant.php
│       └── UserInteraction.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── admin/
│       ├── products/
│       └── recommendations/
└── routes/
    └── web.php
```

## Customization

### Adding New Product Categories
1. Update the Product model's category validation
2. Add category filters to the frontend
3. Update recommendation logic if needed

### Modifying Recommendation Algorithm
1. Edit `RecommendationController.php`
2. Update the `getRecommendedProducts()` method
3. Add new recommendation strategies

### Styling Changes
1. Modify Bootstrap classes in Blade templates
2. Update CSS in layout files
3. Add custom stylesheets

## Security Features

- CSRF protection on all forms
- Input validation and sanitization
- SQL injection prevention
- XSS protection
- Secure file upload handling

## Performance Optimization

- Database indexing on frequently queried columns
- Eager loading for relationships
- Pagination for large datasets
- Caching for recommendation calculations

## Troubleshooting

### Common Issues

1. **Database connection errors**
   - Check `.env` configuration
   - Ensure database file exists (for SQLite)
   - Verify database permissions

2. **File upload issues**
   - Run `php artisan storage:link`
   - Check storage directory permissions
   - Verify upload_max_filesize in php.ini

3. **Recommendation not working**
   - Check if user interactions are being tracked
   - Verify database seeding completed
   - Check session configuration

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support and questions, please create an issue in the repository or contact the development team.
