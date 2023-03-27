```mermaid

erDiagram
    USER }|--o{ GROUP : composes
    GROUP ||--o{ EXPENSE : contains
    USER ||--o{ EXPENSE : pays
    USER }|--|{ EXPENSE : "is concerned by"

USER {
    String username
    String name 
    String surname
    String mail 
    String phoneNumber
}
    
GROUP {
    String name
}

EXPENSE {
    String name
    DateTime date
    String description 
    int amount 
}

```
