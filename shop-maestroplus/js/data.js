const products = [
    {
        id: 1,
        name: 'Cricket Bat',
        price: 1500000,
        category: 'Cricket Equipment',
        rating: 4.5,
        image: 'https://www.mrcrickethockey.com/wp-content/uploads/2019/04/Gunn-and-Moore-Mana-Cricket-Bat-2016.jpg',
        available: true,
        description: 'High-quality cricket bat made from premium willow.',
        specs: [
            'Weight: 1.2 kg',
            'Material: English Willow',
            'Size: Full Size'
        ],
        reviews: [
            {
                user: 'Alice C.',
                rating: 5,
                comment: 'Great balance and power!'
            },
            {
                user: 'Bob D.',
                rating: 4,
                comment: 'Good value for money.'
            }
        ],
        colors: ['Natural']
    },
    {
        id: 2,
        name: 'Cricket Helmet',
        price: 500000,
        category: 'Cricket Equipment',
        rating: 4.7,
        image: 'https://leisurewear.ie/wp-content/uploads/2022/03/GM-Purist-Geo-II-Cricket-Helmet.jpg',
        available: true,
        description: 'Protective cricket helmet with adjustable straps.',
        specs: [
            'Weight: 800 g',
            'Material: Polycarbonate',
            'Size: Adjustable'
        ],
        reviews: [
            {
                user: 'Charlie E.',
                rating: 5,
                comment: 'Very comfortable and safe.'
            }
        ],
        colors: ['Blue', 'Black']
    },
    {
        id: 3,
        name: 'Cricket Gloves',
        price: 300000,
        category: 'Cricket Equipment',
        rating: 4.3,
        image: 'https://gmcricket.in/media/catalog/product/cache/757ea7d2b7282843694bdb6de7a23598/p/r/prima-707-batting-gloves.jpg',
        available: true,
        description: 'Durable cricket gloves for better grip and protection.',
        specs: [
            'Material: Leather',
            'Size: Medium'
        ],
        reviews: [
            {
                user: 'David F.',
                rating: 4,
                comment: 'Good grip and comfort.'
            }
        ],
        colors: ['White']
    },
    {
        id: 4,
        name: 'Cricket Pads',
        price: 400000,
        category: 'Cricket Equipment',
        rating: 4.6,
        image: 'https://www.cricketexpress.co.nz/user/images/2334.jpg?t=1909041330',
        available: true,
        description: 'Lightweight cricket pads for maximum protection.',
        specs: [
            'Material: Foam',
            'Size: Large'
        ],
        reviews: [
            {
                user: 'Eve G.',
                rating: 5,
                comment: 'Excellent protection and fit.'
            }
        ],
        colors: ['White']
    },
    {
        id: 5,
        name: 'Cricket Thigh Pads',
        price: 250000,
        category: 'Cricket Equipment',
        rating: 4.4,
        image: 'https://trevorsmithsports.co.za/wp-content/uploads/2023/02/Cricket-Thigh-Guard-GM-Original-Pad-Short-816x1024.jpg',
        available: true,
        description: 'Comfortable thigh pads for cricket players.',
        specs: [
            'Material: Foam',
            'Size: Adjustable'
        ],
        reviews: [
            {
                user: 'Frank H.',
                rating: 4,
                comment: 'Good protection and comfort.'
            }
        ],
        colors: ['White']
    }
];

const categories = ['All', 'bats', 'helmets', 'gloves', 'pads', 'thigh pads'];

const promotions = [
    {
        id: 1,
        title: 'Summer Sale',
        discount: '20% OFF',
        code: 'SUMMER20',
        validUntil: '2025-02-01'
    },
    {
        id: 2,
        title: 'New User Special',
        discount: 'Rp100.000 OFF',
        code: 'NEWUSER',
        validUntil: '2025-03-01'
    },
    {
        id: 3,
        title: 'Cricket Week',
        discount: '30% OFF',
        code: 'CRICKET30',
        validUntil: '2025-01-31'
    }
];

// Notification data
const notifications = [
    {
        id: 1,
        type: 'order',
        title: 'Order Delivered',
        message: 'Your order #1234 has been delivered successfully',
        timestamp: new Date(2025, 0, 14, 8, 30).getTime(),
        isRead: false,
        icon: 'fa-box-check',
        color: '#820000'
    },
    {
        id: 2,
        type: 'promo',
        title: 'Special Offer',
        message: 'Get 50% off on all winter collection items!',
        timestamp: new Date(2025, 0, 14, 7, 15).getTime(),
        isRead: false,
        icon: 'fa-tag',
        color: '#820000'
    },
    {
        id: 3,
        type: 'news',
        title: 'New Collection Arrived',
        message: 'Check out our latest spring collection',
        timestamp: new Date(2025, 0, 13, 18, 45).getTime(),
        isRead: true,
        icon: 'fa-tshirt',
        color: '#820000'
    },
    {
        id: 4,
        type: 'system',
        title: 'Profile Updated',
        message: 'Your profile information has been updated successfully',
        timestamp: new Date(2025, 0, 13, 15, 20).getTime(),
        isRead: true,
        icon: 'fa-user-check',
        color: '#820000'
    }
];

// Trending tags data
const trendingTags = [
    { id: 1, name: 'Summer Collection', searches: 15420 },
    { id: 2, name: 'Casual Wear', searches: 12350 },
    { id: 3, name: 'Sport Shoes', searches: 11200 },
    { id: 4, name: 'Designer Bags', searches: 9870 },
    { id: 5, name: 'Smart Watches', searches: 8940 },
    { id: 6, name: 'Formal Wear', searches: 7650 },
    { id: 7, name: 'Accessories', searches: 6780 },
    { id: 8, name: 'Winter Wear', searches: 5430 },
    { id: 9, name: 'Ethnic Wear', searches: 4980 },
    { id: 10, name: 'Sunglasses', searches: 4320 },
    { id: 11, name: 'Sneakers', searches: 3890 },
    { id: 12, name: 'Denim', searches: 3450 },
    { id: 13, name: 'Party Wear', searches: 3210 },
    { id: 14, name: 'Fitness Gear', searches: 2980 },
    { id: 15, name: 'Home Decor', searches: 2760 }
];

localStorage.setItem('products', JSON.stringify(products));
