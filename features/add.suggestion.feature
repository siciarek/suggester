# language: pl

@form
Potrzeba biznesowa: Możliwość dodawania sugestii i opinii
  Aby ulepszać i poprawiać funkcjonalność aplikacji
  As a Użytkownik
  Chciałbym mieć możliwość rejestrowania swoich uwag na temat aplikacji

  Założenia:
    Zakładając że w systemie nie ma testowych danych
    I odwiedzę stronę "/"
    I zobaczę tekst "Lista sugestii (0)"
    I zobaczę tekst "Lista jest pusta."

  Scenariusz: Dodanie nowej opini z domyślnymi wartościami formularza
    Zakładając że odwiedzę stronę "/"
    I nie zobaczę tekstu "Sugestia dodana z domyślnymi ustawieniami formularza."
    Jeżeli odwiedzę stronę "/form?application=Suggester"
    I wybiorę opcję "1" w polu "type_id"
    I wypełnię pole "content" wartością "Sugestia dodana z domyślnymi ustawieniami formularza."
    I wypełnię ukryte pole "author" wartością "Acceptance Test"
    I nacisnę przycisk "Zapisz"
    Wtedy powinienem być na stronie "/prompt"
    I kod statusu odpowiedzi powinien być równy 200
    I kod statusu odpowiedzi nie powinien być równy 404
    Jeżeli odwiedzę stronę "/"
    Wtedy zobaczę tekst "Lista sugestii (1)"
    I zobaczę tekst "Sugestia dodana z domyślnymi ustawieniami formularza."

  Scenariusz: Dodanie nowej opini z wybranymi wartościami formularza
    Zakładając że odwiedzę stronę "/"
    I nie zobaczę tekstu "Sugestia dodana z ustawieniami innymi niż domyślne."
    Jeżeli odwiedzę stronę "/form?application=Suggester"
    I wypełnię pole "content" wartością "Sugestia dodana z ustawieniami innymi niż domyślne."
    I wybiorę opcję "3" w polu "type_id"
    I wybiorę opcję "W" w polu "priority"
    I wypełnię ukryte pole "author" wartością "Acceptance Test"
    I nacisnę przycisk "Zapisz"
    Wtedy powinienem być na stronie "/prompt"
    I kod statusu odpowiedzi powinien być równy 200
    I kod statusu odpowiedzi nie powinien być równy 404
    Jeżeli odwiedzę stronę "/"
    Wtedy zobaczę tekst "Lista sugestii (1)"
    I zobaczę tekst "Sugestia dodana z ustawieniami innymi niż domyślne."
