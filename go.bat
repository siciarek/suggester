@ECHO OFF

SET MPATH=app/modules/frontend/models/Entity
SET MNMSPACE=Application\Frontend\Entity

FOR %%T IN ("suggestion") DO (
    phalcon model %%T --name=%%T --namespace=%MNMSPACE% --output=%MPATH% --get-set --force
)
