describe("Login", () => {
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
});
