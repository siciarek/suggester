# language: pl

@access @form
Potrzeba biznesowa: Zapewnienie uprawnionym użytkownikom dostępu do odpowiednich elementów aplikacji
  Aby zapewnić dostęp do części aplikacji tylko uprawnionym użytkownikom
  As a Twórca aplikacji
  Chciałbym mieć pewność, że tylko uprawnieni użytkownicy mają do nich dostęp

  Założenia: Użytkownik powinien być wylogowany a strona powinna być w języku polskim i w trybie produkcyjnym
    Zakładając że aplikacja jest w środowisku produkcyjnym
    I że odwiedzę stronę "/sign-out"
    Oraz odwiedzę stronę "/locale/pl"

  Scenariusz: Próba otwarcia nieistniejącej strony
    Zakładając że odwiedzę stronę "/not/existing/page"
    Wtedy powinienem być na stronie "/not/existing/page"
    Wtedy element "h2.headline.text-info" powinien zawierać "404"
    I kod statusu odpowiedzi powinien być równy 404

  Scenariusz: Próba otwarcia strony na której wystąpił błąd systemowy
    Zakładając że odwiedzę stronę "/test/exception"
    Wtedy powinienem być na stronie "/test/exception"
    Wtedy element "h2.headline.text-info" powinien zawierać "500"
    I kod statusu odpowiedzi powinien być równy 500

  Scenariusz: Sprawdzenie dostępu do publicznej części aplikacji
    Zakładając że odwiedzę stronę "/test/guest"
    Wtedy powinienem być na stronie "/test/guest"
    I kod statusu odpowiedzi powinien być równy 200
    Wtedy zobaczę tekst "Guest"
    I kod statusu odpowiedzi powinien być równy 200

  Scenariusz: Sprawdzenie dostępu do prywatnej części aplikacji zwykłego użytkownika
    Zakładając że odwiedzę stronę "/test/user"
    Wtedy powinienem być na stronie "/sign-in"
    I kod statusu odpowiedzi powinien być równy 200
    Wtedy element "h1.page-header" powinien zawierać "Zaloguj się"
    Jeżeli wypełnię pole "username" wartością "czesolak"
    I wypełnię pole "password" wartością "password"
    I nacisnę przycisk "Zaloguj się"
    Wtedy powinienem być na stronie "/test/user"
    Wtedy zobaczę tekst "User"
    I kod statusu odpowiedzi powinien być równy 200

  Scenariusz: Sprawdzenie dostępu do prywatnej części aplikacji administratora
    Zakładając że odwiedzę stronę "/test/admin"
    Wtedy powinienem być na stronie "/sign-in"
    I kod statusu odpowiedzi powinien być równy 200
    Wtedy element "h1.page-header" powinien zawierać "Zaloguj się"
    Jeżeli wypełnię pole "username" wartością "mariolak"
    I wypełnię pole "password" wartością "password"
    I nacisnę przycisk "Zaloguj się"
    Wtedy powinienem być na stronie "/test/admin"
    Wtedy zobaczę tekst "Admin"
    I kod statusu odpowiedzi powinien być równy 200

  Scenariusz: Sprawdzenie zabezpieczenia dostępu dla zalogowanego użytkownika o nieodpowiednich uprawnieniach
    Zakładając że odwiedzę stronę "/test/user"
    Wtedy powinienem być na stronie "/sign-in"
    I kod statusu odpowiedzi powinien być równy 200
    Wtedy element "h1.page-header" powinien zawierać "Zaloguj się"
    Jeżeli wypełnię pole "username" wartością "czesolak"
    I wypełnię pole "password" wartością "password"
    I nacisnę przycisk "Zaloguj się"
    Wtedy powinienem być na stronie "/test/user"
    Wtedy zobaczę tekst "User"
    I kod statusu odpowiedzi powinien być równy 200
    Jeżeli odwiedzę stronę "/test/admin"
    Wtedy element "h2.headline.text-info" powinien zawierać "403"
    I kod statusu odpowiedzi powinien być równy 403



