<?php
return [
    "CREATE TABLE IF NOT EXISTS profil (
        id SERIAL PRIMARY KEY,
        role VARCHAR(20) NOT NULL CHECK (role IN ('Client', 'Service Commercial'))
        
    )"
];