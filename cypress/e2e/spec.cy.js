describe("Register and Login test", () => {
  it("Register", () => {
    cy.visit("http://localhost:8080/inscription.php");

    cy.get('input[name="email"]').type("test@test.com");
    cy.get('input[name="username"]').type("SlowMoMo");
    cy.get('input[name="password"]').type("Password123");
    cy.get('input[name="co_password"]').type("Password123");

    cy.intercept("POST", "/inscription.php").as("registerRequest");

    cy.get("button#submit_register").click();

    cy.wait("@registerRequest").then((interception) => {
      if (interception.response) {
        cy.log("Response status:", interception.response.statusCode);
        cy.log("Response body:", interception.response.body);
      } else {
        cy.log("No response received");
      }
    });
  });

  it("Displays errors for missing Login", () => {
    cy.visit("http://localhost:8080/connexion.php");

    cy.get("button#submit_login").click();
    cy.get("small#s_login").should(
      "contain.text",
      "Login trop court, minimum 3 lettre !"
    );
  });

  it("Displays errors for missing Password", () => {
    cy.visit("http://localhost:8080/connexion.php");
    cy.get('input[name="username"]').type("Mo");

    cy.get("button#submit_login").click();
    cy.get("small#s_password").should(
      "contain.text",
      "Password trop court, Minimum 3 caractères !"
    );
  });

  it("Displays errors for incorrect Login or Password", () => {
    cy.visit("http://localhost:8080/connexion.php");
    cy.get('input[name="username"]').type("Mola");
    cy.get('input[name="password"').type("NoneNone1");

    cy.get("button#submit_login").click();
    cy.get("p.errs").should("contain.text", "Login ou Password incorrecte !");
  });

  it("Login", () => {
    cy.visit("http://localhost:8080/connexion.php");

    cy.get('input[name="username"]').type("SlowMoMo");
    cy.get('input[name="password"').type("Password123");

    cy.intercept("POST", "/connexion.php").as("loginRequest");

    cy.get("button#submit_login").click();

    cy.wait("@loginRequest").then((interception) => {
      if (interception.response) {
        cy.log("Response status:", interception.response.statusCode);
        cy.log("Response body:", interception.response.body);
      } else {
      }
    });
  });

  it("Add a new comment", () => {
    cy.visit("http://localhost:8080/connexion.php");

    cy.get('input[name="username"]').type("SlowMoMo");
    cy.get('input[name="password"').type("Password123");

    cy.get("button#submit_login").click();

    cy.url().should("include", "/livre-or.php");

    cy.get('input[name="comment"]').get("test.");

    cy.get("button#btn_com").click();
    cy.get("small#s_comment").should(
      "contain.text",
      "Votre commentaire est trop court -Minimum 8 caractère !"
    );

    cy.get('input[name="comment"]').get(
      "quia dolor sit amet, consectetur, adipisci velit"
    );
    cy.get("button#btn_com").click();
    cy.contains("quia dolor sit amet, consectetur, adipisci velit").should(
      "be.visible"
    );
  });
});
