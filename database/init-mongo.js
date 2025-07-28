// Script d'initialisation MongoDB
db = db.getSiblingDB('livre_or');

// Création de la collection utilisateurs avec validation de schéma
db.createCollection("utilisateurs", {
   validator: {
      $jsonSchema: {
         bsonType: "object",
         required: ["email", "login", "password"],
         properties: {
            email: {
               bsonType: "string",
               description: "Email doit être une chaîne et est requis"
            },
            login: {
               bsonType: "string",
               description: "Login doit être une chaîne et est requis"
            },
            password: {
               bsonType: "string",
               description: "Password doit être une chaîne et est requis"
            }
         }
      }
   }
});

// Création de la collection commentaires avec validation de schéma
db.createCollection("commentaires", {
   validator: {
      $jsonSchema: {
         bsonType: "object",
         required: ["commentaire", "id_utilisateur", "date"],
         properties: {
            commentaire: {
               bsonType: "string",
               description: "Commentaire doit être une chaîne et est requis"
            },
            id_utilisateur: {
               bsonType: "objectId",
               description: "ID utilisateur doit être un ObjectId et est requis"
            },
            date: {
               bsonType: "date",
               description: "Date doit être une date et est requise"
            }
         }
      }
   }
});

// Création d'index unique sur le login
db.utilisateurs.createIndex({ "login": 1 }, { unique: true });

// Création d'index sur l'email
db.utilisateurs.createIndex({ "email": 1 });

// Création d'index sur la date des commentaires pour optimiser le tri
db.commentaires.createIndex({ "date": -1 });

print("Base de données MongoDB initialisée avec succès !");
