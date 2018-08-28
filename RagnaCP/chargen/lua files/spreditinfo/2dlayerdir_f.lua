SEX_FEMALE = 0
SEX_MALE = 1
LAYER_BIG = 0
LAYER_SMALL = 1
LayerSizeTypeList = {
	[SPRITE_ROBE_IDs.ROBE_WINGS] = LAYER_BIG,
	[SPRITE_ROBE_IDs.ROBE_BAG_OF_ADVENTURER] = LAYER_SMALL,
	[SPRITE_ROBE_IDs.ROBE_WINGS_OF_FALLEN_ANGEL] = LAYER_BIG,
}
SPRITE_INHERIT_LIST = {
	[JOBID.JT_NOVICE_H] = JOBID.JT_NOVICE,
	[JOBID.JT_SWORDMAN_H] = JOBID.JT_SWORDMAN,
	[JOBID.JT_MAGICIAN_H] = JOBID.JT_MAGICIAN,
	[JOBID.JT_MERCHANT_H] = JOBID.JT_MERCHANT,
	[JOBID.JT_ARCHER_H] = JOBID.JT_ARCHER,
	[JOBID.JT_ACOLYTE_H] = JOBID.JT_ACOLYTE,
	[JOBID.JT_THIEF_H] = JOBID.JT_THIEF,
	[JOBID.JT_SUPERNOVICE2] = JOBID.JT_SUPERNOVICE,
	[JOBID.JT_NOVICE_B] = JOBID.JT_NOVICE,
	[JOBID.JT_SWORDMAN_B] = JOBID.JT_SWORDMAN,
	[JOBID.JT_MAGICIAN_B] = JOBID.JT_MAGICIAN,
	[JOBID.JT_ARCHER_B] = JOBID.JT_ARCHER,
	[JOBID.JT_ACOLYTE_B] = JOBID.JT_ACOLYTE,
	[JOBID.JT_MERCHANT_B] = JOBID.JT_MERCHANT,
	[JOBID.JT_THIEF_B] = JOBID.JT_THIEF,
	[JOBID.JT_KNIGHT_B] = JOBID.JT_KNIGHT,
	[JOBID.JT_PRIEST_B] = JOBID.JT_PRIEST,
	[JOBID.JT_WIZARD_B] = JOBID.JT_WIZARD,
	[JOBID.JT_BLACKSMITH_B] = JOBID.JT_BLACKSMITH,
	[JOBID.JT_HUNTER_B] = JOBID.JT_HUNTER,
	[JOBID.JT_ASSASSIN_B] = JOBID.JT_ASSASSIN,
	[JOBID.JT_CRUSADER_B] = JOBID.JT_CRUSADER,
	[JOBID.JT_MONK_B] = JOBID.JT_MONK,
	[JOBID.JT_SAGE_B] = JOBID.JT_SAGE,
	[JOBID.JT_ROGUE_B] = JOBID.JT_ROGUE,
	[JOBID.JT_ALCHEMIST_B] = JOBID.JT_ALCHEMIST,
	[JOBID.JT_BARD_B] = JOBID.JT_BARD,
	[JOBID.JT_DANCER_B] = JOBID.JT_DANCER,
	[JOBID.JT_SUPERNOVICE_B] = JOBID.JT_SUPERNOVICE,
	[JOBID.JT_RUNE_KNIGHT_B] = JOBID.JT_RUNE_KNIGHT,
	[JOBID.JT_WARLOCK_B] = JOBID.JT_WARLOCK,
	[JOBID.JT_RANGER_B] = JOBID.JT_RANGER,
	[JOBID.JT_ARCHBISHOP_B] = JOBID.JT_ARCHBISHOP,
	[JOBID.JT_MECHANIC_B] = JOBID.JT_MECHANIC,
	[JOBID.JT_GUILLOTINE_CROSS_B] = JOBID.JT_GUILLOTINE_CROSS,
	[JOBID.JT_ROYAL_GUARD_B] = JOBID.JT_ROYAL_GUARD,
	[JOBID.JT_SORCERER_B] = JOBID.JT_SORCERER,
	[JOBID.JT_MINSTREL_B] = JOBID.JT_MINSTREL,
	[JOBID.JT_WANDERER_B] = JOBID.JT_WANDERER,
	[JOBID.JT_SURA_B] = JOBID.JT_SURA,
	[JOBID.JT_GENETIC_B] = JOBID.JT_GENETIC,
	[JOBID.JT_SHADOW_CHASER_B] = JOBID.JT_SHADOW_CHASER,
	[JOBID.JT_SUPERNOVICE2_B] = JOBID.JT_SUPERNOVICE2,
}
EXCEPTION_SPRITE_INHERIT_LIST = {
	[JOBID.JT_GUILLOTINE_CROSS] = JOBID.JT_ASSASSIN,
	[JOBID.JT_ALCHEMIST_H] = JOBID.JT_ALCHEMIST,
	[JOBID.JT_GENETIC] = JOBID.JT_ALCHEMIST,
	[JOBID.JT_DANCER_H] = JOBID.JT_DANCER,
	[JOBID.JT_WANDERER] = JOBID.JT_DANCER,
	[JOBID.JT_BARD_H] = JOBID.JT_BARD,
	[JOBID.JT_MINSTREL] = JOBID.JT_BARD,
	[JOBID.JT_MONK_H] = JOBID.JT_MONK,
	[JOBID.JT_SURA] = JOBID.JT_MONK,
	[JOBID.JT_ROGUE_H] = JOBID.JT_ROGUE,
	[JOBID.JT_SHADOW_CHASER] = JOBID.JT_ROGUE,
	[JOBID.JT_KNIGHT_H] = JOBID.JT_KNIGHT,
	[JOBID.JT_ARCHBISHOP] = JOBID.JT_PRIEST,
	[JOBID.JT_PECO_GUNNER] = JOBID.JT_PECO_SWORD,
	[JOBID.JT_CRUSADER_H] = JOBID.JT_CRUSADER,
	[JOBID.JT_MECHANIC] = JOBID.JT_BLACKSMITH,
	[JOBID.JT_WIZARD_H] = JOBID.JT_WIZARD,
	[JOBID.JT_WARLOCK] = JOBID.JT_WIZARD,
}
RIDING_SPRITE_INHERIT_LIST = {
	[JOBID.JT_PIG_WHITESMITH] = JOBID.JT_PIG_MERCHANT,
	[JOBID.JT_PIG_GENETIC] = JOBID.JT_PIG_MERCHANT,
	[JOBID.JT_PIG_CREATOR] = JOBID.JT_PIG_MERCHANT,
	[JOBID.JT_PIG_ALCHE] = JOBID.JT_PIG_MERCHANT,
	[JOBID.JT_PIG_BLACKSMITH] = JOBID.JT_PIG_MERCHANT,
	[JOBID.JT_PIG_MERCHANT_B] = JOBID.JT_PIG_MERCHANT,
	[JOBID.JT_PIG_GENETIC_B] = JOBID.JT_PIG_MERCHANT,
	[JOBID.JT_PIG_ALCHE_B] = JOBID.JT_PIG_MERCHANT,
	[JOBID.JT_PIG_MERCHANT_H] = JOBID.JT_PIG_MERCHANT,
	[JOBID.JT_PIG_BLACKSMITH_B] = JOBID.JT_PIG_MERCHANT,
	[JOBID.JT_SHEEP_ACO] = JOBID.JT_SHEEP_MONK,
	[JOBID.JT_SHEEP_SURA] = JOBID.JT_SHEEP_MONK,
	[JOBID.JT_SHEEP_ARCB] = JOBID.JT_SHEEP_MONK,
	[JOBID.JT_SHEEP_CHAMP] = JOBID.JT_SHEEP_MONK,
	[JOBID.JT_SHEEP_PRIEST] = JOBID.JT_SHEEP_MONK,
	[JOBID.JT_SHEEP_HPRIEST] = JOBID.JT_SHEEP_MONK,
	[JOBID.JT_SHEEP_ACO_B] = JOBID.JT_SHEEP_MONK,
	[JOBID.JT_SHEEP_MONK_B] = JOBID.JT_SHEEP_MONK,
	[JOBID.JT_SHEEP_ARCB_B] = JOBID.JT_SHEEP_MONK,
	[JOBID.JT_SHEEP_SURA_B] = JOBID.JT_SHEEP_MONK,
	[JOBID.JT_SHEEP_ACO_H] = JOBID.JT_SHEEP_MONK,
	[JOBID.JT_SHEEP_PRIEST_B] = JOBID.JT_SHEEP_MONK,
	[JOBID.JT_DOG_G_CROSS] = JOBID.JT_DOG_THIEF,
	[JOBID.JT_DOG_ROGUE] = JOBID.JT_DOG_THIEF,
	[JOBID.JT_DOG_CHASER] = JOBID.JT_DOG_THIEF,
	[JOBID.JT_DOG_STALKER] = JOBID.JT_DOG_THIEF,
	[JOBID.JT_DOG_ASSASSIN] = JOBID.JT_DOG_THIEF,
	[JOBID.JT_DOG_ASSA_X] = JOBID.JT_DOG_THIEF,
	[JOBID.JT_DOG_ASSASSIN_B] = JOBID.JT_DOG_THIEF,
	[JOBID.JT_DOG_ROGUE_B] = JOBID.JT_DOG_THIEF,
	[JOBID.JT_DOG_G_CROSS_B] = JOBID.JT_DOG_THIEF,
	[JOBID.JT_DOG_CHASER_B] = JOBID.JT_DOG_THIEF,
	[JOBID.JT_DOG_THIEF_H] = JOBID.JT_DOG_THIEF,
	[JOBID.JT_DOG_THIEF_B] = JOBID.JT_DOG_THIEF,
	[JOBID.JT_OSTRICH_DANCER] = JOBID.JT_OSTRICH_ARCHER,
	[JOBID.JT_OSTRICH_MINSTREL] = JOBID.JT_OSTRICH_ARCHER,
	[JOBID.JT_OSTRICH_BARD] = JOBID.JT_OSTRICH_ARCHER,
	[JOBID.JT_OSTRICH_SNIPER] = JOBID.JT_OSTRICH_ARCHER,
	[JOBID.JT_OSTRICH_WANDER] = JOBID.JT_OSTRICH_ARCHER,
	[JOBID.JT_OSTRICH_ZIPSI] = JOBID.JT_OSTRICH_ARCHER,
	[JOBID.JT_OSTRICH_CROWN] = JOBID.JT_OSTRICH_ARCHER,
	[JOBID.JT_OSTRICH_HUNTER] = JOBID.JT_OSTRICH_ARCHER,
	[JOBID.JT_OSTRICH_ARCHER_B] = JOBID.JT_OSTRICH_ARCHER,
	[JOBID.JT_OSTRICH_HUNTER_B] = JOBID.JT_OSTRICH_ARCHER,
	[JOBID.JT_OSTRICH_BARD_B] = JOBID.JT_OSTRICH_ARCHER,
	[JOBID.JT_OSTRICH_DANCER_B] = JOBID.JT_OSTRICH_ARCHER,
	[JOBID.JT_OSTRICH_MINSTREL_B] = JOBID.JT_OSTRICH_ARCHER,
	[JOBID.JT_OSTRICH_WANDER_B] = JOBID.JT_OSTRICH_ARCHER,
	[JOBID.JT_OSTRICH_ARCHER_H] = JOBID.JT_OSTRICH_ARCHER,
	[JOBID.JT_FOX_SAGE] = JOBID.JT_FOX_MAGICIAN,
	[JOBID.JT_FOX_SORCERER] = JOBID.JT_FOX_MAGICIAN,
	[JOBID.JT_FOX_WARLOCK] = JOBID.JT_FOX_MAGICIAN,
	[JOBID.JT_FOX_WIZ] = JOBID.JT_FOX_MAGICIAN,
	[JOBID.JT_FOX_HWIZ] = JOBID.JT_FOX_MAGICIAN,
	[JOBID.JT_FOX_MAGICIAN_B] = JOBID.JT_FOX_MAGICIAN,
	[JOBID.JT_FOX_SAGE_B] = JOBID.JT_FOX_MAGICIAN,
	[JOBID.JT_FOX_WARLOCK_B] = JOBID.JT_FOX_MAGICIAN,
	[JOBID.JT_FOX_SORCERER_B] = JOBID.JT_FOX_MAGICIAN,
	[JOBID.JT_FOX_MAGICIAN_H] = JOBID.JT_FOX_MAGICIAN,
	[JOBID.JT_FOX_WIZ_B] = JOBID.JT_FOX_MAGICIAN,
	[JOBID.JT_PORING_STAR] = JOBID.JT_PORING_NOVICE,
	[JOBID.JT_PORING_SNOVICE] = JOBID.JT_PORING_NOVICE,
	[JOBID.JT_PORING_TAEKWON] = JOBID.JT_PORING_NOVICE,
	[JOBID.JT_PORING_NOVICE_B] = JOBID.JT_PORING_NOVICE,
	[JOBID.JT_PORING_SNOVICE_B] = JOBID.JT_PORING_NOVICE,
	[JOBID.JT_PORING_NOVICE_H] = JOBID.JT_PORING_NOVICE,
	[JOBID.JT_PORING_SNOVICE2] = JOBID.JT_PORING_NOVICE,
	[JOBID.JT_PORING_SNOVICE2_B] = JOBID.JT_PORING_NOVICE,
	[JOBID.JT_FROG_KAGEROU] = JOBID.JT_FROG_NINJA,
	[JOBID.JT_FROG_OBORO] = JOBID.JT_FROG_NINJA,
}

--Function #0
GetLayerSizeType = function(robeID)
	if LayerSizeTypeList[robeID] == nil then
		return LAYER_BIG
	end
	local sizeType = LayerSizeTypeList[robeID]
	if sizeType ~= nil then
		return sizeType
	else
		return LAYER_BIG
	end
end

--Function #1
GetLayerDirTbl = function(sex, robeID)
	local sizeType = GetLayerSizeType(robeID)
	if sizeType == LAYER_BIG then
		if sex == SEX_FEMALE then
			return BigLayerDir_F
		else
			return BigLayerDir_M
		end
	elseif sizeType == LAYER_SMALL then
		if sex == SEX_FEMALE then
			return SmallLayerDir_F
		else
			return SmallLayerDir_M
		end
	end
end

--Function #2
GetSpriteInheriteJob = function(jobID)
	if RIDING_SPRITE_INHERIT_LIST ~= nil and RIDING_SPRITE_INHERIT_LIST[jobID] ~= nil then
		jobID = RIDING_SPRITE_INHERIT_LIST[jobID]
	end
	if JOB_INHERIT_LIST2 ~= nil and JOB_INHERIT_LIST2[jobID] ~= nil then
		jobID = JOB_INHERIT_LIST2[jobID]
	end
	if SPRITE_INHERIT_LIST ~= nil and SPRITE_INHERIT_LIST[jobID] ~= nil then
		jobID = SPRITE_INHERIT_LIST[jobID]
	end
	local sizeType = GetLayerSizeType(robeID)
	if sizeType == LAYER_BIG then
		if EXCEPTION_SPRITE_INHERIT_LIST ~= nil and EXCEPTION_SPRITE_INHERIT_LIST[jobID] ~= nil then
			jobID = EXCEPTION_SPRITE_INHERIT_LIST[jobID]
		end
	end
	return jobID
end

--Function #3
DrawOnTop = function(robeID, sex, jobID, actNum, motNum)
	local LayerDirTbl = GetLayerDirTbl(sex, robeID)
	jobID = GetSpriteInheriteJob(jobID)
	if LayerDirTbl == nil or LayerDirTbl[jobID] == nil then
		return true
	end
	if LayerDirTbl[jobID][actNum] == nil then
		return true
	end
	local idx = 1
	motInfo = LayerDirTbl[jobID][actNum][idx]
	while motInfo ~= nil do
		if motInfo == motNum then
			return false
		end
		idx = idx +1
		motInfo = LayerDirTbl[jobID][actNum][idx]
	end
	return true
end