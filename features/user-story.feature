Feature : View balance

  Given I am a user of the application
  When I am on the "View balance" page
  I want to see a summary of the credits and debits of the group members

  Scenario: The balance of my group is displayed
    Given I am a member of the group
      And I have access to the balance of all group members
    When I am on the group home screen
      And I click on "Afficher balance"
    Then I am redirected to the balance display page
      And I see the positive or negative balance of each group member

Fonctionnalité Afficher la balance
  En tant qu'utilisateur de l'application
  Quand je suis sur la page "Affichage balance"
  Je voudrais voir un récapitulatif des crédits et débits des membres du groupe

  Scenario: La balance de mon groupe s'affiche
    Etant donné que je suis membre du groupe
      Et que j'ai accès à la balance de tous les membres du groupe
    Quand je suis sur l'écran d'accueil du groupe
      Et que je clique sur "Afficher la balance" 
    Alors je suis redirigé.e vers la page d'affichage de la balance
      Et je vois le solde positif ou négatif de chaque membre du groupe