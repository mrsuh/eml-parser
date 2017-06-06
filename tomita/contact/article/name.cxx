#encoding "utf8"
#GRAMMAR_ROOT ROOT

End -> AnyWord<wff="с"> AnyWord<wff="уважением">;
Begin -> AnyWord<wff="from|to">;

NameRegexp -> Word Word Word | Word Word | Word;
Name -> NameRegexp<kwset=~[person]>;

ROOT -> End AnyWord Name interp (FactPerson.Name::not_norm);
