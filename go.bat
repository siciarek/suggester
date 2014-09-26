REM vendor\phalcon\devtools\phalcon.bat model suggestion_type --name=suggestion_type --namespace=Application\Frontend\Entity --output=app/modules/frontend/models/entities --get-set --force
REM vendor\phalcon\devtools\phalcon.bat model suggestion --name=suggestion --namespace=Application\Frontend\Entity --output=app/modules/frontend/models/entities --get-set --force

set MODEL=worker
set TABLE=user
vendor\phalcon\devtools\phalcon.bat model %MODEL% --name=%TABLE% --namespace=Application\Frontend\Entity --output=app/modules/frontend/models/entities --get-set --force
