set TABLE=client
set MODEL=%TABLE%
vendor\phalcon\devtools\phalcon.bat model %MODEL% --name=%TABLE% --namespace=Application\Frontend\Entity --output=app/modules/frontend/models/Entity --get-set --force
