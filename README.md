# webwoelfe-spiel
OnlineErgänzung zum Spiel Werwölfe

## Installation

Erfolgt als lokales symfony 4 Projekt einfach per Terminal mit [composer](https://getcomposer.org/) zu installieren:

`$ composer install`

Anschließend in der .env Datei die Datenbankverbindung konfigurieren. Bspw. mit sqlite wie folgt:

`DATABASE_URL=sqlite:///%kernel.project_dir%/var/webwoelfe.db`

Und über die symfony Konsole die Datenbank initialisieren:

`$ ./bin/console doctrine:schema:update --force`

Einen lokalen Webserver liefert symfony mit, kann über die symfony Konsole gestartet werden:

`$ symfony server:start -d`

## Admin

Kann verwendet werden, um die erzeugten Entitäten zu kontrollieren bzw. zu bearbeiten.

Am besten in einem separaten Verzeichnis erstellen:

```
$ npm create react-app my-admin
$ cd my-admin
$ add @api-platform/admin
```

und in der dann den Inhalt der entstandenen src/App.js mit diesem ersetzen (Achtung: korrekten Link zur API angeben!):

```
import React from "react";
import { HydraAdmin } from "@api-platform/admin";

// Replace with your own API entrypoint
// For instance if https://example.com/api/books is the path to the collection of book resources, then the entrypoint is https://example.com/api
export default () => (
  <HydraAdmin entrypoint="https://demo.api-platform.com" />
);
```

Mit einem lokalen npm Server kann man auch das schnell starten:

`$ npm start`
