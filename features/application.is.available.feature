# language: pl

@available
Potrzeba biznesowa: Zapewnienie dostępności aplikacji
  Aby korzystać z aplikacji
  As a Użytkownik
  Chciałbym mieć pewność, że aplikacja jest dostępna

  Scenariusz: Powtórne sprawdzenie czy działa strona listy
    Jeżeli odwiedzę stronę "/"
    Wtedy powinienem być na stronie "/"
    I kod statusu odpowiedzi powinien być równy 200
    I kod statusu odpowiedzi nie powinien być równy 404

  Scenariusz: Sprawdzenie czy działa strona formularza
    Jeżeli odwiedzę stronę "/form"
    Wtedy powinienem być na stronie "/form"
    I kod statusu odpowiedzi powinien być równy 200
    I kod statusu odpowiedzi nie powinien być równy 404

